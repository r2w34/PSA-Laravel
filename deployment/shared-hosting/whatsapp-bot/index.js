const express = require('express');
const cors = require('cors');
const dotenv = require('dotenv');
const path = require('path');
const fs = require('fs-extra');
const cron = require('node-cron');

// Load environment variables
dotenv.config();

// Import modules
const WhatsAppBot = require('./src/WhatsAppBot');
const MessageTemplates = require('./src/MessageTemplates');
const LaravelAPI = require('./src/LaravelAPI');
const Logger = require('./src/Logger');
const CronJobs = require('./src/CronJobs');

class PSAWhatsAppService {
    constructor() {
        this.app = express();
        this.port = process.env.PORT || 3001;
        this.bot = null;
        this.logger = new Logger();
        this.laravelAPI = new LaravelAPI();
        this.messageTemplates = new MessageTemplates();
        this.cronJobs = new CronJobs(this);
        
        this.setupMiddleware();
        this.setupRoutes();
        this.initializeDirectories();
    }

    setupMiddleware() {
        this.app.use(cors({
            origin: process.env.ALLOWED_ORIGINS?.split(',') || ['http://localhost:51897'],
            credentials: true
        }));
        
        this.app.use(express.json());
        this.app.use(express.urlencoded({ extended: true }));
        
        // Request logging
        this.app.use((req, res, next) => {
            this.logger.info(`${req.method} ${req.path}`, { 
                ip: req.ip, 
                userAgent: req.get('User-Agent') 
            });
            next();
        });
    }

    setupRoutes() {
        // Health check
        this.app.get('/health', (req, res) => {
            res.json({
                status: 'ok',
                service: 'PSA WhatsApp Bot',
                version: '1.0.0',
                uptime: process.uptime(),
                bot_status: this.bot ? this.bot.getStatus() : 'not_initialized'
            });
        });

        // Bot status
        this.app.get('/status', (req, res) => {
            if (!this.bot) {
                return res.status(503).json({
                    success: false,
                    message: 'Bot not initialized'
                });
            }

            res.json({
                success: true,
                data: {
                    status: this.bot.getStatus(),
                    session_exists: this.bot.hasSession(),
                    last_activity: this.bot.getLastActivity(),
                    message_queue_size: this.bot.getQueueSize()
                }
            });
        });

        // Initialize bot
        this.app.post('/initialize', async (req, res) => {
            try {
                if (this.bot && this.bot.isReady()) {
                    return res.json({
                        success: true,
                        message: 'Bot already initialized and ready'
                    });
                }

                await this.initializeBot();
                
                res.json({
                    success: true,
                    message: 'Bot initialization started'
                });
            } catch (error) {
                this.logger.error('Failed to initialize bot', error);
                res.status(500).json({
                    success: false,
                    message: 'Failed to initialize bot',
                    error: error.message
                });
            }
        });

        // Send message
        this.app.post('/send-message', async (req, res) => {
            try {
                const { phone, message, type = 'text' } = req.body;

                if (!phone || !message) {
                    return res.status(400).json({
                        success: false,
                        message: 'Phone and message are required'
                    });
                }

                if (!this.bot || !this.bot.isReady()) {
                    return res.status(503).json({
                        success: false,
                        message: 'Bot not ready'
                    });
                }

                const result = await this.bot.sendMessage(phone, message, type);
                
                res.json({
                    success: true,
                    message: 'Message sent successfully',
                    data: result
                });
            } catch (error) {
                this.logger.error('Failed to send message', error);
                res.status(500).json({
                    success: false,
                    message: 'Failed to send message',
                    error: error.message
                });
            }
        });

        // Send fee reminder
        this.app.post('/send-fee-reminder', async (req, res) => {
            try {
                const { student_id, payment_details } = req.body;

                if (!student_id) {
                    return res.status(400).json({
                        success: false,
                        message: 'Student ID is required'
                    });
                }

                const result = await this.sendFeeReminder(student_id, payment_details);
                
                res.json({
                    success: true,
                    message: 'Fee reminder sent successfully',
                    data: result
                });
            } catch (error) {
                this.logger.error('Failed to send fee reminder', error);
                res.status(500).json({
                    success: false,
                    message: 'Failed to send fee reminder',
                    error: error.message
                });
            }
        });

        // Send session notification
        this.app.post('/send-session-notification', async (req, res) => {
            try {
                const { batch_id, session_details } = req.body;

                if (!batch_id) {
                    return res.status(400).json({
                        success: false,
                        message: 'Batch ID is required'
                    });
                }

                const result = await this.sendSessionNotification(batch_id, session_details);
                
                res.json({
                    success: true,
                    message: 'Session notification sent successfully',
                    data: result
                });
            } catch (error) {
                this.logger.error('Failed to send session notification', error);
                res.status(500).json({
                    success: false,
                    message: 'Failed to send session notification',
                    error: error.message
                });
            }
        });

        // Get QR code for authentication
        this.app.get('/qr-code', (req, res) => {
            if (!this.bot) {
                return res.status(503).json({
                    success: false,
                    message: 'Bot not initialized'
                });
            }

            const qrCode = this.bot.getQRCode();
            if (!qrCode) {
                return res.status(404).json({
                    success: false,
                    message: 'QR code not available'
                });
            }

            res.json({
                success: true,
                data: {
                    qr_code: qrCode,
                    expires_at: this.bot.getQRExpiry()
                }
            });
        });

        // Webhook for Laravel
        this.app.post('/webhook', (req, res) => {
            try {
                const { event, data } = req.body;
                
                // Verify webhook secret
                const signature = req.headers['x-webhook-signature'];
                if (!this.verifyWebhookSignature(signature, req.body)) {
                    return res.status(401).json({
                        success: false,
                        message: 'Invalid webhook signature'
                    });
                }

                this.handleWebhookEvent(event, data);
                
                res.json({
                    success: true,
                    message: 'Webhook processed successfully'
                });
            } catch (error) {
                this.logger.error('Webhook processing failed', error);
                res.status(500).json({
                    success: false,
                    message: 'Webhook processing failed',
                    error: error.message
                });
            }
        });
    }

    async initializeDirectories() {
        const dirs = [
            './sessions',
            './logs',
            './temp'
        ];

        for (const dir of dirs) {
            await fs.ensureDir(path.join(__dirname, dir));
        }
    }

    async initializeBot() {
        if (this.bot) {
            await this.bot.destroy();
        }

        this.bot = new WhatsAppBot({
            sessionPath: process.env.WHATSAPP_SESSION_PATH || './sessions',
            headless: process.env.WHATSAPP_HEADLESS === 'true',
            timeout: parseInt(process.env.WHATSAPP_TIMEOUT) || 60000,
            logger: this.logger
        });

        // Set up bot event handlers
        this.bot.on('ready', () => {
            this.logger.info('WhatsApp bot is ready');
        });

        this.bot.on('qr', (qr) => {
            this.logger.info('QR code generated for WhatsApp authentication');
        });

        this.bot.on('authenticated', () => {
            this.logger.info('WhatsApp bot authenticated successfully');
        });

        this.bot.on('disconnected', () => {
            this.logger.warn('WhatsApp bot disconnected');
        });

        this.bot.on('error', (error) => {
            this.logger.error('WhatsApp bot error', error);
        });

        await this.bot.initialize();
    }

    async sendFeeReminder(studentId, paymentDetails = null) {
        if (!this.bot || !this.bot.isReady()) {
            throw new Error('Bot not ready');
        }

        // Get student details from Laravel API
        const student = await this.laravelAPI.getStudent(studentId);
        if (!student) {
            throw new Error('Student not found');
        }

        // Get outstanding payments if not provided
        if (!paymentDetails) {
            paymentDetails = await this.laravelAPI.getStudentOutstandingPayments(studentId);
        }

        // Generate message
        const message = this.messageTemplates.getFeeReminderMessage(student, paymentDetails);
        
        // Send message
        const result = await this.bot.sendMessage(student.phone, message);
        
        // Log the activity
        await this.laravelAPI.logActivity('fee_reminder_sent', {
            student_id: studentId,
            phone: student.phone,
            message_id: result.id
        });

        return result;
    }

    async sendSessionNotification(batchId, sessionDetails = null) {
        if (!this.bot || !this.bot.isReady()) {
            throw new Error('Bot not ready');
        }

        // Get batch details and students
        const batch = await this.laravelAPI.getBatch(batchId);
        if (!batch) {
            throw new Error('Batch not found');
        }

        const students = await this.laravelAPI.getBatchStudents(batchId);
        
        // Generate message
        const message = this.messageTemplates.getSessionNotificationMessage(batch, sessionDetails);
        
        const results = [];
        
        // Send to all students in the batch
        for (const student of students) {
            try {
                const result = await this.bot.sendMessage(student.phone, message);
                results.push({
                    student_id: student.id,
                    phone: student.phone,
                    status: 'sent',
                    message_id: result.id
                });
                
                // Small delay to avoid rate limiting
                await new Promise(resolve => setTimeout(resolve, 1000));
            } catch (error) {
                this.logger.error(`Failed to send session notification to ${student.phone}`, error);
                results.push({
                    student_id: student.id,
                    phone: student.phone,
                    status: 'failed',
                    error: error.message
                });
            }
        }

        // Log the activity
        await this.laravelAPI.logActivity('session_notification_sent', {
            batch_id: batchId,
            students_count: students.length,
            results: results
        });

        return results;
    }

    handleWebhookEvent(event, data) {
        this.logger.info(`Webhook event received: ${event}`, data);

        switch (event) {
            case 'fee_reminder':
                this.sendFeeReminder(data.student_id, data.payment_details)
                    .catch(error => this.logger.error('Fee reminder webhook failed', error));
                break;
                
            case 'session_notification':
                this.sendSessionNotification(data.batch_id, data.session_details)
                    .catch(error => this.logger.error('Session notification webhook failed', error));
                break;
                
            case 'attendance_alert':
                this.sendAttendanceAlert(data.student_id, data.attendance_data)
                    .catch(error => this.logger.error('Attendance alert webhook failed', error));
                break;
                
            default:
                this.logger.warn(`Unknown webhook event: ${event}`);
        }
    }

    verifyWebhookSignature(signature, body) {
        // Implement webhook signature verification
        const crypto = require('crypto');
        const secret = process.env.WEBHOOK_SECRET;
        
        if (!secret || !signature) {
            return false;
        }

        const expectedSignature = crypto
            .createHmac('sha256', secret)
            .update(JSON.stringify(body))
            .digest('hex');

        return signature === `sha256=${expectedSignature}`;
    }

    async start() {
        try {
            // Initialize bot
            await this.initializeBot();
            
            // Start cron jobs
            this.cronJobs.start();
            
            // Start Express server
            this.app.listen(this.port, () => {
                this.logger.info(`PSA WhatsApp Bot Service started on port ${this.port}`);
                console.log(`🚀 PSA WhatsApp Bot Service running on http://localhost:${this.port}`);
                console.log(`📱 Health check: http://localhost:${this.port}/health`);
            });
        } catch (error) {
            this.logger.error('Failed to start WhatsApp service', error);
            process.exit(1);
        }
    }

    async stop() {
        this.logger.info('Stopping PSA WhatsApp Bot Service...');
        
        // Stop cron jobs
        this.cronJobs.stop();
        
        // Destroy bot
        if (this.bot) {
            await this.bot.destroy();
        }
        
        process.exit(0);
    }
}

// Handle graceful shutdown
process.on('SIGINT', async () => {
    console.log('\n🛑 Received SIGINT, shutting down gracefully...');
    if (global.whatsappService) {
        await global.whatsappService.stop();
    }
});

process.on('SIGTERM', async () => {
    console.log('\n🛑 Received SIGTERM, shutting down gracefully...');
    if (global.whatsappService) {
        await global.whatsappService.stop();
    }
});

// Start the service
if (require.main === module) {
    const service = new PSAWhatsAppService();
    global.whatsappService = service;
    service.start();
}

module.exports = PSAWhatsAppService;