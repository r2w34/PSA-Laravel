const cron = require('node-cron');

class CronJobs {
    constructor(whatsappService) {
        this.whatsappService = whatsappService;
        this.logger = whatsappService.logger;
        this.laravelAPI = whatsappService.laravelAPI;
        this.messageTemplates = whatsappService.messageTemplates;
        
        this.jobs = new Map();
        this.isRunning = false;
        
        this.setupJobs();
    }

    setupJobs() {
        // Fee reminder job - Every Monday at 9 AM
        this.addJob('feeReminder', {
            schedule: process.env.FEE_REMINDER_CRON || '0 9 * * 1',
            enabled: process.env.ENABLE_FEE_REMINDERS === 'true',
            task: this.sendFeeReminders.bind(this),
            description: 'Send fee reminders to students with outstanding payments'
        });

        // Session notification job - Every day at 8 AM
        this.addJob('sessionNotification', {
            schedule: process.env.SESSION_REMINDER_CRON || '0 8 * * *',
            enabled: process.env.ENABLE_SESSION_NOTIFICATIONS === 'true',
            task: this.sendSessionNotifications.bind(this),
            description: 'Send session reminders for upcoming training sessions'
        });

        // Attendance alert job - Every day at 6 PM
        this.addJob('attendanceAlert', {
            schedule: process.env.ATTENDANCE_ALERT_CRON || '0 18 * * *',
            enabled: process.env.ENABLE_ATTENDANCE_ALERTS === 'true',
            task: this.sendAttendanceAlerts.bind(this),
            description: 'Send attendance alerts for students with low attendance'
        });

        // Birthday wishes job - Every day at 10 AM
        this.addJob('birthdayWishes', {
            schedule: '0 10 * * *',
            enabled: true,
            task: this.sendBirthdayWishes.bind(this),
            description: 'Send birthday wishes to students'
        });

        // Health check job - Every 30 minutes
        this.addJob('healthCheck', {
            schedule: '*/30 * * * *',
            enabled: true,
            task: this.performHealthCheck.bind(this),
            description: 'Perform health check on WhatsApp bot and Laravel API'
        });

        // Log rotation job - Every day at midnight
        this.addJob('logRotation', {
            schedule: '0 0 * * *',
            enabled: true,
            task: this.performLogMaintenance.bind(this),
            description: 'Rotate and clean old log files'
        });

        // Weekly report job - Every Sunday at 9 PM
        this.addJob('weeklyReport', {
            schedule: '0 21 * * 0',
            enabled: false, // Disabled by default
            task: this.sendWeeklyReport.bind(this),
            description: 'Send weekly activity report to administrators'
        });
    }

    addJob(name, config) {
        if (!cron.validate(config.schedule)) {
            this.logger.error(`Invalid cron schedule for job ${name}`, { schedule: config.schedule });
            return false;
        }

        this.jobs.set(name, {
            ...config,
            instance: null,
            lastRun: null,
            nextRun: null,
            runCount: 0,
            errorCount: 0
        });

        this.logger.info(`Cron job registered: ${name}`, {
            schedule: config.schedule,
            enabled: config.enabled,
            description: config.description
        });

        return true;
    }

    start() {
        if (this.isRunning) {
            this.logger.warn('Cron jobs are already running');
            return;
        }

        this.logger.info('Starting cron jobs...');

        for (const [name, job] of this.jobs) {
            if (job.enabled) {
                try {
                    job.instance = cron.schedule(job.schedule, async () => {
                        await this.executeJob(name, job);
                    }, {
                        scheduled: false,
                        timezone: 'Asia/Kolkata'
                    });

                    job.instance.start();
                    job.nextRun = this.getNextRunTime(job.schedule);
                    
                    this.logger.info(`Cron job started: ${name}`, {
                        schedule: job.schedule,
                        nextRun: job.nextRun
                    });
                } catch (error) {
                    this.logger.error(`Failed to start cron job: ${name}`, error);
                }
            } else {
                this.logger.info(`Cron job disabled: ${name}`);
            }
        }

        this.isRunning = true;
        this.logger.info('All enabled cron jobs started successfully');
    }

    stop() {
        if (!this.isRunning) {
            this.logger.warn('Cron jobs are not running');
            return;
        }

        this.logger.info('Stopping cron jobs...');

        for (const [name, job] of this.jobs) {
            if (job.instance) {
                job.instance.stop();
                job.instance = null;
                this.logger.info(`Cron job stopped: ${name}`);
            }
        }

        this.isRunning = false;
        this.logger.info('All cron jobs stopped');
    }

    async executeJob(name, job) {
        const startTime = Date.now();
        
        try {
            this.logger.info(`Executing cron job: ${name}`);
            
            job.lastRun = new Date();
            job.runCount++;
            
            await job.task();
            
            const duration = Date.now() - startTime;
            job.nextRun = this.getNextRunTime(job.schedule);
            
            this.logger.info(`Cron job completed: ${name}`, {
                duration: `${duration}ms`,
                runCount: job.runCount,
                nextRun: job.nextRun
            });
            
        } catch (error) {
            const duration = Date.now() - startTime;
            job.errorCount++;
            
            this.logger.error(`Cron job failed: ${name}`, {
                error: error.message,
                duration: `${duration}ms`,
                errorCount: job.errorCount
            });
            
            // Log to Laravel API
            await this.laravelAPI.logActivity('cron_job_error', {
                job_name: name,
                error: error.message,
                duration: duration,
                error_count: job.errorCount
            });
        }
    }

    // Job implementations
    async sendFeeReminders() {
        if (!this.whatsappService.bot || !this.whatsappService.bot.isReady()) {
            this.logger.warn('WhatsApp bot not ready, skipping fee reminders');
            return;
        }

        const candidates = await this.laravelAPI.getFeeReminderCandidates();
        this.logger.info(`Found ${candidates.length} fee reminder candidates`);

        let successCount = 0;
        let errorCount = 0;

        for (const candidate of candidates) {
            try {
                await this.whatsappService.sendFeeReminder(
                    candidate.student.id,
                    {
                        amount: candidate.total_amount,
                        due_date: candidate.payments[0]?.due_date,
                        payments: candidate.payments
                    }
                );
                
                successCount++;
                
                // Small delay to avoid rate limiting
                await new Promise(resolve => setTimeout(resolve, 2000));
                
            } catch (error) {
                errorCount++;
                this.logger.error(`Failed to send fee reminder to student ${candidate.student.id}`, error);
            }
        }

        this.logger.info('Fee reminders job completed', {
            total: candidates.length,
            success: successCount,
            errors: errorCount
        });

        // Log activity
        await this.laravelAPI.logActivity('fee_reminders_sent', {
            total_candidates: candidates.length,
            success_count: successCount,
            error_count: errorCount
        });
    }

    async sendSessionNotifications() {
        if (!this.whatsappService.bot || !this.whatsappService.bot.isReady()) {
            this.logger.warn('WhatsApp bot not ready, skipping session notifications');
            return;
        }

        const batches = await this.laravelAPI.getSessionNotificationCandidates();
        this.logger.info(`Found ${batches.length} batches for session notifications`);

        let successCount = 0;
        let errorCount = 0;

        for (const batch of batches) {
            try {
                await this.whatsappService.sendSessionNotification(batch.id);
                successCount++;
                
                // Delay between batches
                await new Promise(resolve => setTimeout(resolve, 5000));
                
            } catch (error) {
                errorCount++;
                this.logger.error(`Failed to send session notification for batch ${batch.id}`, error);
            }
        }

        this.logger.info('Session notifications job completed', {
            total: batches.length,
            success: successCount,
            errors: errorCount
        });

        // Log activity
        await this.laravelAPI.logActivity('session_notifications_sent', {
            total_batches: batches.length,
            success_count: successCount,
            error_count: errorCount
        });
    }

    async sendAttendanceAlerts() {
        if (!this.whatsappService.bot || !this.whatsappService.bot.isReady()) {
            this.logger.warn('WhatsApp bot not ready, skipping attendance alerts');
            return;
        }

        const students = await this.laravelAPI.getAttendanceAlertCandidates();
        this.logger.info(`Found ${students.length} students for attendance alerts`);

        let successCount = 0;
        let errorCount = 0;

        for (const student of students) {
            try {
                const attendanceData = await this.laravelAPI.getStudentAttendance(student.id);
                
                if (attendanceData.attendance_rate < 70) { // Less than 70% attendance
                    const message = this.messageTemplates.getAttendanceAlertMessage(student, {
                        missed_sessions: attendanceData.absent_sessions,
                        last_attended: attendanceData.last_attended,
                        attendance_rate: attendanceData.attendance_rate
                    });
                    
                    await this.whatsappService.bot.sendMessage(student.phone, message);
                    successCount++;
                    
                    // Log the activity
                    await this.laravelAPI.logActivity('attendance_alert_sent', {
                        student_id: student.id,
                        attendance_rate: attendanceData.attendance_rate
                    });
                }
                
                // Small delay
                await new Promise(resolve => setTimeout(resolve, 2000));
                
            } catch (error) {
                errorCount++;
                this.logger.error(`Failed to send attendance alert to student ${student.id}`, error);
            }
        }

        this.logger.info('Attendance alerts job completed', {
            total: students.length,
            success: successCount,
            errors: errorCount
        });
    }

    async sendBirthdayWishes() {
        if (!this.whatsappService.bot || !this.whatsappService.bot.isReady()) {
            this.logger.warn('WhatsApp bot not ready, skipping birthday wishes');
            return;
        }

        const students = await this.laravelAPI.getBirthdayCandidates();
        this.logger.info(`Found ${students.length} students with birthdays today`);

        let successCount = 0;
        let errorCount = 0;

        for (const student of students) {
            try {
                const message = this.messageTemplates.getBirthdayWishMessage(student);
                await this.whatsappService.bot.sendMessage(student.phone, message);
                
                successCount++;
                
                // Log the activity
                await this.laravelAPI.logActivity('birthday_wish_sent', {
                    student_id: student.id
                });
                
                // Small delay
                await new Promise(resolve => setTimeout(resolve, 2000));
                
            } catch (error) {
                errorCount++;
                this.logger.error(`Failed to send birthday wish to student ${student.id}`, error);
            }
        }

        this.logger.info('Birthday wishes job completed', {
            total: students.length,
            success: successCount,
            errors: errorCount
        });
    }

    async performHealthCheck() {
        try {
            // Check WhatsApp bot health
            const botHealth = this.whatsappService.bot ? 
                await this.whatsappService.bot.healthCheck() : 
                { status: 'unhealthy', reason: 'Bot not initialized' };

            // Check Laravel API health
            const apiHealth = await this.laravelAPI.healthCheck();

            const overallHealth = {
                status: botHealth.status === 'healthy' && apiHealth.status === 'healthy' ? 'healthy' : 'unhealthy',
                bot: botHealth,
                api: apiHealth,
                timestamp: new Date()
            };

            if (overallHealth.status === 'unhealthy') {
                this.logger.warn('Health check failed', overallHealth);
                
                // Log to Laravel API if possible
                if (apiHealth.status === 'healthy') {
                    await this.laravelAPI.logActivity('health_check_failed', overallHealth);
                }
            } else {
                this.logger.debug('Health check passed', overallHealth);
            }

        } catch (error) {
            this.logger.error('Health check error', error);
        }
    }

    async performLogMaintenance() {
        try {
            // Rotate logs
            await this.logger.rotateLog();
            
            // Clean old logs (keep 30 days)
            await this.logger.cleanOldLogs(30);
            
            this.logger.info('Log maintenance completed');
            
        } catch (error) {
            this.logger.error('Log maintenance failed', error);
        }
    }

    async sendWeeklyReport() {
        try {
            // This would generate and send a weekly report
            // Implementation depends on specific requirements
            this.logger.info('Weekly report job executed (not implemented)');
            
        } catch (error) {
            this.logger.error('Weekly report job failed', error);
        }
    }

    // Utility methods
    getNextRunTime(schedule) {
        try {
            // This is a simplified implementation
            // In a real scenario, you'd use a proper cron parser
            return new Date(Date.now() + 24 * 60 * 60 * 1000); // Next day
        } catch (error) {
            return null;
        }
    }

    // Management methods
    enableJob(name) {
        const job = this.jobs.get(name);
        if (job) {
            job.enabled = true;
            if (this.isRunning && !job.instance) {
                // Start the job if cron system is running
                this.startSingleJob(name, job);
            }
            this.logger.info(`Job enabled: ${name}`);
            return true;
        }
        return false;
    }

    disableJob(name) {
        const job = this.jobs.get(name);
        if (job) {
            job.enabled = false;
            if (job.instance) {
                job.instance.stop();
                job.instance = null;
            }
            this.logger.info(`Job disabled: ${name}`);
            return true;
        }
        return false;
    }

    startSingleJob(name, job) {
        try {
            job.instance = cron.schedule(job.schedule, async () => {
                await this.executeJob(name, job);
            }, {
                scheduled: false,
                timezone: 'Asia/Kolkata'
            });

            job.instance.start();
            job.nextRun = this.getNextRunTime(job.schedule);
            
        } catch (error) {
            this.logger.error(`Failed to start job: ${name}`, error);
        }
    }

    getJobStatus() {
        const status = {};
        
        for (const [name, job] of this.jobs) {
            status[name] = {
                enabled: job.enabled,
                running: job.instance !== null,
                schedule: job.schedule,
                description: job.description,
                lastRun: job.lastRun,
                nextRun: job.nextRun,
                runCount: job.runCount,
                errorCount: job.errorCount
            };
        }
        
        return {
            systemRunning: this.isRunning,
            jobs: status
        };
    }
}

module.exports = CronJobs;