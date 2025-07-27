const axios = require('axios');

class LaravelAPI {
    constructor() {
        this.baseURL = process.env.LARAVEL_API_URL || 'http://localhost:51897/api/v1';
        this.token = process.env.LARAVEL_API_TOKEN;
        
        this.client = axios.create({
            baseURL: this.baseURL,
            timeout: 30000,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        // Add request interceptor to include auth token
        this.client.interceptors.request.use(
            (config) => {
                if (this.token) {
                    config.headers.Authorization = `Bearer ${this.token}`;
                }
                return config;
            },
            (error) => {
                return Promise.reject(error);
            }
        );

        // Add response interceptor for error handling
        this.client.interceptors.response.use(
            (response) => {
                return response.data;
            },
            (error) => {
                console.error('Laravel API Error:', {
                    url: error.config?.url,
                    method: error.config?.method,
                    status: error.response?.status,
                    message: error.response?.data?.message || error.message
                });
                return Promise.reject(error);
            }
        );
    }

    // Authentication methods
    async authenticate(email, password) {
        try {
            const response = await this.client.post('/login', {
                email,
                password
            });
            
            if (response.success && response.data.token) {
                this.token = response.data.token;
                this.client.defaults.headers.Authorization = `Bearer ${this.token}`;
                return response.data;
            }
            
            throw new Error('Authentication failed');
        } catch (error) {
            throw new Error(`Authentication failed: ${error.message}`);
        }
    }

    // Student methods
    async getStudent(studentId) {
        try {
            const response = await this.client.get(`/students/${studentId}`);
            return response.success ? response.data : null;
        } catch (error) {
            console.error(`Failed to get student ${studentId}:`, error.message);
            return null;
        }
    }

    async getStudents(filters = {}) {
        try {
            const response = await this.client.get('/students', { params: filters });
            return response.success ? response.data : [];
        } catch (error) {
            console.error('Failed to get students:', error.message);
            return [];
        }
    }

    async getStudentsByBatch(batchId) {
        try {
            const response = await this.client.get('/students', {
                params: { batch_id: batchId }
            });
            return response.success ? response.data : [];
        } catch (error) {
            console.error(`Failed to get students for batch ${batchId}:`, error.message);
            return [];
        }
    }

    // Payment methods
    async getStudentOutstandingPayments(studentId) {
        try {
            const response = await this.client.get(`/payments-student/${studentId}`, {
                params: { status: 'pending' }
            });
            
            if (response.success && response.data.length > 0) {
                // Calculate total outstanding amount
                const totalAmount = response.data.reduce((sum, payment) => {
                    return sum + parseFloat(payment.amount || 0);
                }, 0);
                
                return {
                    payments: response.data,
                    total_amount: totalAmount,
                    count: response.data.length,
                    due_date: response.data[0]?.due_date || null
                };
            }
            
            return {
                payments: [],
                total_amount: 0,
                count: 0,
                due_date: null
            };
        } catch (error) {
            console.error(`Failed to get outstanding payments for student ${studentId}:`, error.message);
            return {
                payments: [],
                total_amount: 0,
                count: 0,
                due_date: null
            };
        }
    }

    async getPayment(paymentId) {
        try {
            const response = await this.client.get(`/payments/${paymentId}`);
            return response.success ? response.data : null;
        } catch (error) {
            console.error(`Failed to get payment ${paymentId}:`, error.message);
            return null;
        }
    }

    // Batch methods
    async getBatch(batchId) {
        try {
            const response = await this.client.get(`/batches/${batchId}`);
            return response.success ? response.data : null;
        } catch (error) {
            console.error(`Failed to get batch ${batchId}:`, error.message);
            return null;
        }
    }

    async getBatchStudents(batchId) {
        try {
            const batch = await this.getBatch(batchId);
            if (batch && batch.students) {
                return batch.students;
            }
            
            // Fallback: get students by batch filter
            return await this.getStudentsByBatch(batchId);
        } catch (error) {
            console.error(`Failed to get batch students for ${batchId}:`, error.message);
            return [];
        }
    }

    async getTodaysBatches() {
        try {
            const today = new Date().toISOString().split('T')[0];
            const response = await this.client.get('/batches', {
                params: { 
                    date: today,
                    status: 'active'
                }
            });
            return response.success ? response.data : [];
        } catch (error) {
            console.error('Failed to get today\'s batches:', error.message);
            return [];
        }
    }

    // Coach methods
    async getCoach(coachId) {
        try {
            const response = await this.client.get(`/coaches/${coachId}`);
            return response.success ? response.data : null;
        } catch (error) {
            console.error(`Failed to get coach ${coachId}:`, error.message);
            return null;
        }
    }

    // Attendance methods
    async getStudentAttendance(studentId, fromDate = null, toDate = null) {
        try {
            const params = { student_id: studentId };
            if (fromDate) params.from_date = fromDate;
            if (toDate) params.to_date = toDate;
            
            const response = await this.client.get('/attendance', { params });
            
            if (response.success) {
                const attendance = response.data;
                const totalSessions = attendance.length;
                const presentSessions = attendance.filter(a => a.status === 'present').length;
                const attendanceRate = totalSessions > 0 ? (presentSessions / totalSessions) * 100 : 0;
                
                return {
                    records: attendance,
                    total_sessions: totalSessions,
                    present_sessions: presentSessions,
                    absent_sessions: totalSessions - presentSessions,
                    attendance_rate: attendanceRate,
                    last_attended: this.getLastAttendedDate(attendance)
                };
            }
            
            return {
                records: [],
                total_sessions: 0,
                present_sessions: 0,
                absent_sessions: 0,
                attendance_rate: 0,
                last_attended: null
            };
        } catch (error) {
            console.error(`Failed to get attendance for student ${studentId}:`, error.message);
            return {
                records: [],
                total_sessions: 0,
                present_sessions: 0,
                absent_sessions: 0,
                attendance_rate: 0,
                last_attended: null
            };
        }
    }

    getLastAttendedDate(attendanceRecords) {
        const presentRecords = attendanceRecords
            .filter(record => record.status === 'present')
            .sort((a, b) => new Date(b.date) - new Date(a.date));
        
        return presentRecords.length > 0 ? presentRecords[0].date : null;
    }

    // Activity logging
    async logActivity(event, data) {
        try {
            const response = await this.client.post('/activities', {
                event,
                data,
                source: 'whatsapp_bot',
                timestamp: new Date().toISOString()
            });
            return response.success;
        } catch (error) {
            console.error('Failed to log activity:', error.message);
            return false;
        }
    }

    // Notification methods
    async createNotification(userId, title, message, type = 'info') {
        try {
            const response = await this.client.post('/notifications', {
                user_id: userId,
                title,
                message,
                type,
                source: 'whatsapp_bot'
            });
            return response.success ? response.data : null;
        } catch (error) {
            console.error('Failed to create notification:', error.message);
            return null;
        }
    }

    // Dashboard statistics
    async getDashboardStats() {
        try {
            const response = await this.client.get('/dashboard-stats');
            return response.success ? response.data : null;
        } catch (error) {
            console.error('Failed to get dashboard stats:', error.message);
            return null;
        }
    }

    // Fee reminder candidates
    async getFeeReminderCandidates() {
        try {
            // Get students with outstanding payments
            const response = await this.client.get('/payments', {
                params: {
                    status: 'pending',
                    overdue: true
                }
            });
            
            if (response.success) {
                // Group by student
                const studentPayments = {};
                response.data.forEach(payment => {
                    if (!studentPayments[payment.student_id]) {
                        studentPayments[payment.student_id] = {
                            student: payment.student,
                            payments: [],
                            total_amount: 0
                        };
                    }
                    studentPayments[payment.student_id].payments.push(payment);
                    studentPayments[payment.student_id].total_amount += parseFloat(payment.amount);
                });
                
                return Object.values(studentPayments);
            }
            
            return [];
        } catch (error) {
            console.error('Failed to get fee reminder candidates:', error.message);
            return [];
        }
    }

    // Session notification candidates
    async getSessionNotificationCandidates() {
        try {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().split('T')[0];
            
            const response = await this.client.get('/batches', {
                params: {
                    date: tomorrowStr,
                    status: 'active'
                }
            });
            
            return response.success ? response.data : [];
        } catch (error) {
            console.error('Failed to get session notification candidates:', error.message);
            return [];
        }
    }

    // Attendance alert candidates
    async getAttendanceAlertCandidates() {
        try {
            const oneWeekAgo = new Date();
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
            
            const response = await this.client.get('/students', {
                params: {
                    low_attendance: true,
                    from_date: oneWeekAgo.toISOString().split('T')[0]
                }
            });
            
            return response.success ? response.data : [];
        } catch (error) {
            console.error('Failed to get attendance alert candidates:', error.message);
            return [];
        }
    }

    // Birthday candidates
    async getBirthdayCandidates() {
        try {
            const today = new Date().toISOString().split('T')[0];
            
            const response = await this.client.get('/students', {
                params: {
                    birthday: today
                }
            });
            
            return response.success ? response.data : [];
        } catch (error) {
            console.error('Failed to get birthday candidates:', error.message);
            return [];
        }
    }

    // Health check
    async healthCheck() {
        try {
            const response = await this.client.get('/health');
            return {
                status: 'healthy',
                api_status: response.status || 'ok',
                response_time: Date.now()
            };
        } catch (error) {
            return {
                status: 'unhealthy',
                error: error.message,
                response_time: Date.now()
            };
        }
    }

    // Set API token
    setToken(token) {
        this.token = token;
        this.client.defaults.headers.Authorization = `Bearer ${token}`;
    }

    // Get current token
    getToken() {
        return this.token;
    }
}

module.exports = LaravelAPI;