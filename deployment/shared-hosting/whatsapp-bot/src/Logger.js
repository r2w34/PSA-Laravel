const fs = require('fs-extra');
const path = require('path');

class Logger {
    constructor(options = {}) {
        this.logLevel = options.logLevel || process.env.LOG_LEVEL || 'info';
        this.logFile = options.logFile || process.env.LOG_FILE || './logs/whatsapp-bot.log';
        this.enableConsole = options.enableConsole !== false;
        this.enableFile = options.enableFile !== false;
        
        this.levels = {
            error: 0,
            warn: 1,
            info: 2,
            debug: 3
        };
        
        this.currentLevel = this.levels[this.logLevel] || this.levels.info;
        
        // Ensure log directory exists
        if (this.enableFile) {
            this.ensureLogDirectory();
        }
    }

    async ensureLogDirectory() {
        const logDir = path.dirname(this.logFile);
        await fs.ensureDir(logDir);
    }

    shouldLog(level) {
        return this.levels[level] <= this.currentLevel;
    }

    formatMessage(level, message, meta = {}) {
        const timestamp = new Date().toISOString();
        const metaStr = Object.keys(meta).length > 0 ? ` ${JSON.stringify(meta)}` : '';
        return `[${timestamp}] ${level.toUpperCase()}: ${message}${metaStr}`;
    }

    async writeToFile(formattedMessage) {
        if (!this.enableFile) return;
        
        try {
            await fs.appendFile(this.logFile, formattedMessage + '\n');
        } catch (error) {
            console.error('Failed to write to log file:', error.message);
        }
    }

    writeToConsole(level, message, meta = {}) {
        if (!this.enableConsole) return;
        
        const timestamp = new Date().toISOString();
        const prefix = `[${timestamp}] ${level.toUpperCase()}:`;
        
        switch (level) {
            case 'error':
                console.error(prefix, message, meta);
                break;
            case 'warn':
                console.warn(prefix, message, meta);
                break;
            case 'info':
                console.info(prefix, message, meta);
                break;
            case 'debug':
                console.debug(prefix, message, meta);
                break;
            default:
                console.log(prefix, message, meta);
        }
    }

    async log(level, message, meta = {}) {
        if (!this.shouldLog(level)) return;
        
        const formattedMessage = this.formatMessage(level, message, meta);
        
        // Write to console
        this.writeToConsole(level, message, meta);
        
        // Write to file
        if (this.enableFile) {
            await this.writeToFile(formattedMessage);
        }
    }

    error(message, meta = {}) {
        return this.log('error', message, meta);
    }

    warn(message, meta = {}) {
        return this.log('warn', message, meta);
    }

    info(message, meta = {}) {
        return this.log('info', message, meta);
    }

    debug(message, meta = {}) {
        return this.log('debug', message, meta);
    }

    // Log rotation
    async rotateLog() {
        if (!this.enableFile || !await fs.pathExists(this.logFile)) {
            return;
        }

        try {
            const stats = await fs.stat(this.logFile);
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (stats.size > maxSize) {
                const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
                const rotatedFile = `${this.logFile}.${timestamp}`;
                
                await fs.move(this.logFile, rotatedFile);
                this.info('Log file rotated', { rotatedTo: rotatedFile });
            }
        } catch (error) {
            console.error('Failed to rotate log file:', error.message);
        }
    }

    // Clean old log files
    async cleanOldLogs(daysToKeep = 30) {
        if (!this.enableFile) return;
        
        try {
            const logDir = path.dirname(this.logFile);
            const logBasename = path.basename(this.logFile);
            const files = await fs.readdir(logDir);
            
            const cutoffDate = new Date();
            cutoffDate.setDate(cutoffDate.getDate() - daysToKeep);
            
            for (const file of files) {
                if (file.startsWith(logBasename) && file !== logBasename) {
                    const filePath = path.join(logDir, file);
                    const stats = await fs.stat(filePath);
                    
                    if (stats.mtime < cutoffDate) {
                        await fs.remove(filePath);
                        this.info('Old log file removed', { file: file });
                    }
                }
            }
        } catch (error) {
            console.error('Failed to clean old logs:', error.message);
        }
    }

    // Get log stats
    async getLogStats() {
        if (!this.enableFile || !await fs.pathExists(this.logFile)) {
            return null;
        }

        try {
            const stats = await fs.stat(this.logFile);
            const content = await fs.readFile(this.logFile, 'utf8');
            const lines = content.split('\n').filter(line => line.trim());
            
            const levelCounts = {
                error: 0,
                warn: 0,
                info: 0,
                debug: 0
            };
            
            lines.forEach(line => {
                Object.keys(levelCounts).forEach(level => {
                    if (line.includes(level.toUpperCase() + ':')) {
                        levelCounts[level]++;
                    }
                });
            });
            
            return {
                file: this.logFile,
                size: stats.size,
                created: stats.birthtime,
                modified: stats.mtime,
                totalLines: lines.length,
                levelCounts: levelCounts
            };
        } catch (error) {
            console.error('Failed to get log stats:', error.message);
            return null;
        }
    }

    // Get recent logs
    async getRecentLogs(lines = 100) {
        if (!this.enableFile || !await fs.pathExists(this.logFile)) {
            return [];
        }

        try {
            const content = await fs.readFile(this.logFile, 'utf8');
            const allLines = content.split('\n').filter(line => line.trim());
            
            return allLines.slice(-lines);
        } catch (error) {
            console.error('Failed to get recent logs:', error.message);
            return [];
        }
    }

    // Set log level
    setLogLevel(level) {
        if (this.levels.hasOwnProperty(level)) {
            this.logLevel = level;
            this.currentLevel = this.levels[level];
            this.info('Log level changed', { newLevel: level });
        } else {
            this.warn('Invalid log level', { level: level, validLevels: Object.keys(this.levels) });
        }
    }

    // Get current log level
    getLogLevel() {
        return this.logLevel;
    }
}

module.exports = Logger;