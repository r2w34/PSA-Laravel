const puppeteer = require('puppeteer');
const fs = require('fs-extra');
const path = require('path');
const EventEmitter = require('events');
const qrcode = require('qrcode-terminal');

class WhatsAppBot extends EventEmitter {
    constructor(options = {}) {
        super();
        
        this.options = {
            sessionPath: options.sessionPath || './sessions',
            headless: options.headless !== false,
            timeout: options.timeout || 60000,
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ...options
        };
        
        this.browser = null;
        this.page = null;
        this.isInitialized = false;
        this.isAuthenticated = false;
        this.qrCode = null;
        this.qrExpiry = null;
        this.lastActivity = null;
        this.messageQueue = [];
        this.logger = options.logger || console;
        
        this.selectors = {
            qrCode: 'div[data-ref] canvas',
            qrCodeContainer: 'div[data-ref]',
            chatList: 'div[data-testid="chat-list"]',
            searchBox: 'div[contenteditable="true"][data-tab="3"]',
            messageBox: 'div[contenteditable="true"][data-tab="10"]',
            sendButton: 'span[data-testid="send"]',
            contactName: 'span[data-testid="conversation-info-header-chat-title"]',
            messageStatus: 'span[data-testid="msg-check"]',
            newChatButton: 'div[data-testid="chat-list-header"] button',
            contactSearch: 'div[contenteditable="true"][data-tab="2"]'
        };
    }

    async initialize() {
        try {
            this.logger.info('Initializing WhatsApp bot...');
            
            // Ensure session directory exists
            await fs.ensureDir(this.options.sessionPath);
            
            // Launch browser
            this.browser = await puppeteer.launch({
                headless: this.options.headless ? 'new' : false,
                args: [
                    '--no-sandbox',
                    '--disable-setuid-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-accelerated-2d-canvas',
                    '--no-first-run',
                    '--no-zygote',
                    '--disable-gpu',
                    '--disable-web-security',
                    '--disable-features=VizDisplayCompositor',
                    '--disable-extensions',
                    '--disable-plugins',
                    '--disable-background-timer-throttling',
                    '--disable-backgrounding-occluded-windows',
                    '--disable-renderer-backgrounding'
                ],
                userDataDir: this.options.sessionPath
            });

            this.page = await this.browser.newPage();
            
            // Set user agent
            await this.page.setUserAgent(this.options.userAgent);
            
            // Set viewport
            await this.page.setViewport({ width: 1366, height: 768 });
            
            // Navigate to WhatsApp Web
            await this.page.goto('https://web.whatsapp.com', {
                waitUntil: 'networkidle2',
                timeout: this.options.timeout
            });

            this.logger.info('WhatsApp Web loaded');
            
            // Check if already authenticated
            await this.checkAuthenticationStatus();
            
            this.isInitialized = true;
            this.lastActivity = new Date();
            
        } catch (error) {
            this.logger.error('Failed to initialize WhatsApp bot', error);
            this.emit('error', error);
            throw error;
        }
    }

    async checkAuthenticationStatus() {
        try {
            // Wait for either QR code or chat list to appear
            const result = await Promise.race([
                this.page.waitForSelector(this.selectors.qrCode, { timeout: 10000 }).then(() => 'qr'),
                this.page.waitForSelector(this.selectors.chatList, { timeout: 10000 }).then(() => 'authenticated')
            ]);

            if (result === 'qr') {
                this.logger.info('QR code detected, waiting for authentication');
                await this.handleQRCode();
            } else if (result === 'authenticated') {
                this.logger.info('Already authenticated');
                this.isAuthenticated = true;
                this.emit('authenticated');
                this.emit('ready');
            }
        } catch (error) {
            this.logger.error('Authentication check failed', error);
            throw error;
        }
    }

    async handleQRCode() {
        try {
            // Get QR code
            const qrElement = await this.page.$(this.selectors.qrCode);
            if (qrElement) {
                const qrCodeData = await qrElement.evaluate(canvas => canvas.toDataURL());
                this.qrCode = qrCodeData;
                this.qrExpiry = new Date(Date.now() + 60000); // QR expires in 1 minute
                
                // Display QR in terminal if not headless
                if (!this.options.headless) {
                    const qrText = await this.page.evaluate(() => {
                        const canvas = document.querySelector('div[data-ref] canvas');
                        return canvas ? canvas.getAttribute('data-ref') : null;
                    });
                    
                    if (qrText) {
                        qrcode.generate(qrText, { small: true });
                    }
                }
                
                this.emit('qr', this.qrCode);
                
                // Wait for authentication
                await this.waitForAuthentication();
            }
        } catch (error) {
            this.logger.error('QR code handling failed', error);
            throw error;
        }
    }

    async waitForAuthentication() {
        try {
            // Wait for chat list to appear (indicates successful authentication)
            await this.page.waitForSelector(this.selectors.chatList, {
                timeout: 120000 // 2 minutes timeout
            });
            
            this.isAuthenticated = true;
            this.qrCode = null;
            this.qrExpiry = null;
            
            this.logger.info('WhatsApp authentication successful');
            this.emit('authenticated');
            this.emit('ready');
            
        } catch (error) {
            this.logger.error('Authentication timeout', error);
            this.emit('error', new Error('Authentication timeout'));
            throw error;
        }
    }

    async sendMessage(phone, message, type = 'text') {
        if (!this.isReady()) {
            throw new Error('Bot not ready');
        }

        try {
            this.logger.info(`Sending message to ${phone}`);
            
            // Format phone number
            const formattedPhone = this.formatPhoneNumber(phone);
            
            // Open chat with the contact
            await this.openChat(formattedPhone);
            
            // Send message based on type
            let result;
            switch (type) {
                case 'text':
                    result = await this.sendTextMessage(message);
                    break;
                case 'image':
                    result = await this.sendImageMessage(message);
                    break;
                default:
                    throw new Error(`Unsupported message type: ${type}`);
            }
            
            this.lastActivity = new Date();
            
            return {
                id: result.id || Date.now().toString(),
                phone: formattedPhone,
                message: message,
                type: type,
                status: 'sent',
                timestamp: new Date()
            };
            
        } catch (error) {
            this.logger.error(`Failed to send message to ${phone}`, error);
            throw error;
        }
    }

    async openChat(phone) {
        try {
            // Use WhatsApp Web URL to open chat directly
            const chatUrl = `https://web.whatsapp.com/send?phone=${phone}`;
            await this.page.goto(chatUrl, {
                waitUntil: 'networkidle2',
                timeout: 30000
            });
            
            // Wait for message box to be available
            await this.page.waitForSelector(this.selectors.messageBox, {
                timeout: 15000
            });
            
            this.logger.info(`Chat opened for ${phone}`);
            
        } catch (error) {
            this.logger.error(`Failed to open chat for ${phone}`, error);
            throw error;
        }
    }

    async sendTextMessage(message) {
        try {
            // Click on message box
            await this.page.click(this.selectors.messageBox);
            
            // Type message
            await this.page.type(this.selectors.messageBox, message);
            
            // Wait a bit for the message to be processed
            await this.page.waitForTimeout(500);
            
            // Click send button
            await this.page.click(this.selectors.sendButton);
            
            // Wait for message to be sent
            await this.page.waitForTimeout(1000);
            
            this.logger.info('Text message sent successfully');
            
            return {
                id: Date.now().toString(),
                type: 'text',
                content: message
            };
            
        } catch (error) {
            this.logger.error('Failed to send text message', error);
            throw error;
        }
    }

    async sendImageMessage(imagePath) {
        try {
            // Click attachment button
            const attachButton = await this.page.$('div[data-testid="clip"]');
            if (attachButton) {
                await attachButton.click();
                
                // Wait for attachment menu
                await this.page.waitForTimeout(1000);
                
                // Click image/video option
                const imageButton = await this.page.$('input[accept="image/*,video/mp4,video/3gpp,video/quicktime"]');
                if (imageButton) {
                    await imageButton.uploadFile(imagePath);
                    
                    // Wait for image to load
                    await this.page.waitForTimeout(2000);
                    
                    // Click send button
                    const sendButton = await this.page.$('span[data-testid="send"]');
                    if (sendButton) {
                        await sendButton.click();
                        
                        this.logger.info('Image message sent successfully');
                        
                        return {
                            id: Date.now().toString(),
                            type: 'image',
                            content: imagePath
                        };
                    }
                }
            }
            
            throw new Error('Failed to find attachment controls');
            
        } catch (error) {
            this.logger.error('Failed to send image message', error);
            throw error;
        }
    }

    formatPhoneNumber(phone) {
        // Remove all non-digit characters
        let cleaned = phone.replace(/\D/g, '');
        
        // Add country code if not present
        if (!cleaned.startsWith('91') && cleaned.length === 10) {
            cleaned = '91' + cleaned;
        }
        
        return cleaned;
    }

    isReady() {
        return this.isInitialized && this.isAuthenticated && this.browser && this.page;
    }

    getStatus() {
        if (!this.isInitialized) return 'not_initialized';
        if (!this.isAuthenticated) return 'waiting_for_auth';
        if (this.isReady()) return 'ready';
        return 'error';
    }

    hasSession() {
        return fs.existsSync(path.join(this.options.sessionPath, 'Default'));
    }

    getQRCode() {
        return this.qrCode;
    }

    getQRExpiry() {
        return this.qrExpiry;
    }

    getLastActivity() {
        return this.lastActivity;
    }

    getQueueSize() {
        return this.messageQueue.length;
    }

    async destroy() {
        try {
            this.logger.info('Destroying WhatsApp bot...');
            
            if (this.page) {
                await this.page.close();
                this.page = null;
            }
            
            if (this.browser) {
                await this.browser.close();
                this.browser = null;
            }
            
            this.isInitialized = false;
            this.isAuthenticated = false;
            this.qrCode = null;
            this.qrExpiry = null;
            
            this.emit('disconnected');
            
        } catch (error) {
            this.logger.error('Error destroying WhatsApp bot', error);
        }
    }

    // Health check method
    async healthCheck() {
        if (!this.isReady()) {
            return { status: 'unhealthy', reason: 'Bot not ready' };
        }

        try {
            // Check if page is still responsive
            await this.page.evaluate(() => document.title);
            
            return { 
                status: 'healthy',
                last_activity: this.lastActivity,
                session_exists: this.hasSession()
            };
        } catch (error) {
            return { 
                status: 'unhealthy', 
                reason: 'Page not responsive',
                error: error.message 
            };
        }
    }
}

module.exports = WhatsAppBot;