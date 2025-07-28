const express = require('express');
const cors = require('cors');

const app = express();
const port = process.env.PORT || 3001;

// Middleware
app.use(cors({
    origin: ['http://localhost:51897', 'http://localhost:56918'],
    credentials: true
}));
app.use(express.json());

// Mock WhatsApp service status
let mockStatus = {
    status: 'online',
    authenticated: false,
    qrCode: null,
    lastActivity: new Date().toISOString(),
    messagesSent: 0,
    messagesReceived: 0
};

// Routes
app.get('/status', (req, res) => {
    res.json({
        success: true,
        data: mockStatus
    });
});

app.get('/qr', (req, res) => {
    res.json({
        success: true,
        data: {
            qrCode: mockStatus.qrCode,
            authenticated: mockStatus.authenticated
        }
    });
});

app.post('/send-message', (req, res) => {
    const { phone, message, type = 'text' } = req.body;
    
    if (!phone || !message) {
        return res.status(400).json({
            success: false,
            error: 'Phone and message are required'
        });
    }
    
    // Mock message sending
    mockStatus.messagesSent++;
    mockStatus.lastActivity = new Date().toISOString();
    
    console.log(`[MOCK] Sending ${type} message to ${phone}: ${message}`);
    
    res.json({
        success: true,
        data: {
            messageId: `mock_${Date.now()}`,
            phone,
            message,
            type,
            status: 'sent',
            timestamp: new Date().toISOString()
        }
    });
});

app.post('/send-bulk-message', (req, res) => {
    const { phones, message, type = 'text' } = req.body;
    
    if (!phones || !Array.isArray(phones) || !message) {
        return res.status(400).json({
            success: false,
            error: 'Phones array and message are required'
        });
    }
    
    // Mock bulk message sending
    const results = phones.map(phone => {
        mockStatus.messagesSent++;
        console.log(`[MOCK] Sending ${type} message to ${phone}: ${message}`);
        
        return {
            messageId: `mock_${Date.now()}_${phone}`,
            phone,
            message,
            type,
            status: 'sent',
            timestamp: new Date().toISOString()
        };
    });
    
    mockStatus.lastActivity = new Date().toISOString();
    
    res.json({
        success: true,
        data: {
            totalSent: results.length,
            results
        }
    });
});

app.post('/send-fee-reminder', (req, res) => {
    const { student_id, payment_details } = req.body;
    
    mockStatus.messagesSent++;
    mockStatus.lastActivity = new Date().toISOString();
    
    console.log(`[MOCK] Sending fee reminder to student ${student_id}`);
    console.log(`[MOCK] Payment details:`, payment_details);
    
    res.json({
        success: true,
        data: {
            messageId: `mock_fee_${Date.now()}`,
            studentId: student_id,
            type: 'fee_reminder',
            status: 'sent',
            timestamp: new Date().toISOString()
        }
    });
});

app.post('/send-session-notification', (req, res) => {
    const { batch_id, session_details } = req.body;
    
    mockStatus.messagesSent++;
    mockStatus.lastActivity = new Date().toISOString();
    
    console.log(`[MOCK] Sending session notification to batch ${batch_id}`);
    console.log(`[MOCK] Session details:`, session_details);
    
    res.json({
        success: true,
        data: {
            messageId: `mock_session_${Date.now()}`,
            batchId: batch_id,
            type: 'session_notification',
            status: 'sent',
            timestamp: new Date().toISOString()
        }
    });
});

app.post('/authenticate', (req, res) => {
    // Mock authentication
    mockStatus.authenticated = true;
    mockStatus.qrCode = null;
    
    res.json({
        success: true,
        data: {
            authenticated: true,
            message: 'Mock authentication successful'
        }
    });
});

app.post('/logout', (req, res) => {
    // Mock logout
    mockStatus.authenticated = false;
    mockStatus.qrCode = 'mock_qr_code_data';
    
    res.json({
        success: true,
        data: {
            authenticated: false,
            message: 'Mock logout successful'
        }
    });
});

app.get('/health', (req, res) => {
    res.json({
        success: true,
        data: {
            service: 'PSA WhatsApp Bot (Mock)',
            status: 'healthy',
            uptime: process.uptime(),
            memory: process.memoryUsage(),
            timestamp: new Date().toISOString()
        }
    });
});

// Error handling
app.use((err, req, res, next) => {
    console.error('Error:', err);
    res.status(500).json({
        success: false,
        error: 'Internal server error'
    });
});

// 404 handler
app.use((req, res) => {
    res.status(404).json({
        success: false,
        error: 'Endpoint not found'
    });
});

// Start server
app.listen(port, '0.0.0.0', () => {
    console.log(`[MOCK] PSA WhatsApp Bot Mock Service running on port ${port}`);
    console.log(`[MOCK] Status: ${mockStatus.status}`);
    console.log(`[MOCK] Authenticated: ${mockStatus.authenticated}`);
    
    // Simulate QR code generation for unauthenticated state
    if (!mockStatus.authenticated) {
        mockStatus.qrCode = 'mock_qr_code_data_' + Date.now();
        console.log(`[MOCK] QR Code generated: ${mockStatus.qrCode}`);
    }
});

// Graceful shutdown
process.on('SIGTERM', () => {
    console.log('[MOCK] Received SIGTERM, shutting down gracefully');
    process.exit(0);
});

process.on('SIGINT', () => {
    console.log('[MOCK] Received SIGINT, shutting down gracefully');
    process.exit(0);
});