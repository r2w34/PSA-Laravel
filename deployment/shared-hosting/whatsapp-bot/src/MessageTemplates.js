const moment = require('moment');

class MessageTemplates {
    constructor() {
        this.templates = {
            feeReminder: {
                subject: '💰 Fee Reminder - PSA Sports Academy',
                greeting: 'Dear {studentName},',
                body: `
We hope you are doing well and enjoying your training at PSA Sports Academy! 🏏

This is a friendly reminder regarding your pending fee payment:

📋 *Payment Details:*
• Student: {studentName}
• Sport: {sportName}
• Batch: {batchName}
• Amount Due: ₹{amount}
• Due Date: {dueDate}
• Days Overdue: {daysOverdue}

💳 *Payment Methods:*
• Cash payment at academy
• Online transfer: [Bank Details]
• UPI: psasports@upi

Please make the payment at your earliest convenience to avoid any interruption in your training.

For any queries, contact us at:
📞 Phone: +91-XXXXXXXXXX
📧 Email: admin@psasports.com

Thank you for choosing PSA Sports Academy! 🙏

Best regards,
PSA Sports Academy Team
                `.trim()
            },

            sessionNotification: {
                subject: '🏃‍♂️ Training Session Reminder - PSA Sports Academy',
                greeting: 'Dear Students & Parents,',
                body: `
Get ready for your upcoming training session! 💪

📅 *Session Details:*
• Sport: {sportName}
• Batch: {batchName}
• Coach: {coachName}
• Date: {sessionDate}
• Time: {sessionTime}
• Venue: {venue}
• Duration: {duration}

🎯 *What to bring:*
• Sports attire and shoes
• Water bottle
• Towel
• Any specific equipment mentioned by coach

⚠️ *Important Notes:*
{specialInstructions}

Please arrive 10 minutes early for warm-up. In case of any emergency or if you cannot attend, please inform us immediately.

For any queries, contact:
📞 Coach {coachName}: {coachPhone}
📞 Academy: +91-XXXXXXXXXX

See you on the field! 🏆

Best regards,
PSA Sports Academy Team
                `.trim()
            },

            attendanceAlert: {
                subject: '⚠️ Attendance Alert - PSA Sports Academy',
                greeting: 'Dear Parent/Guardian,',
                body: `
We noticed that {studentName} has been absent from recent training sessions.

📊 *Attendance Summary:*
• Student: {studentName}
• Sport: {sportName}
• Batch: {batchName}
• Sessions Missed: {missedSessions}
• Last Attended: {lastAttended}
• Attendance Rate: {attendanceRate}%

Regular attendance is crucial for skill development and progress. We encourage consistent participation to get the maximum benefit from our training programs.

If there are any specific reasons for the absences or if you need to discuss the training schedule, please feel free to contact us.

📞 Contact Details:
• Coach {coachName}: {coachPhone}
• Academy Office: +91-XXXXXXXXXX
• Email: admin@psasports.com

We look forward to seeing {studentName} back in action soon! 💪

Best regards,
PSA Sports Academy Team
                `.trim()
            },

            welcomeMessage: {
                subject: '🎉 Welcome to PSA Sports Academy!',
                greeting: 'Dear {studentName} & Family,',
                body: `
Welcome to the PSA Sports Academy family! 🏆

We are thrilled to have you join us on this exciting sports journey. Here are your enrollment details:

👤 *Student Information:*
• Name: {studentName}
• Sport: {sportName}
• Batch: {batchName}
• Coach: {coachName}
• Start Date: {startDate}

📅 *Training Schedule:*
{trainingSchedule}

📋 *What's Next:*
1. Attend your first session on {firstSessionDate}
2. Bring sports attire and water bottle
3. Meet your coach and fellow students
4. Complete any pending documentation

📞 *Important Contacts:*
• Coach {coachName}: {coachPhone}
• Academy Office: +91-XXXXXXXXXX
• Emergency: +91-XXXXXXXXXX

We're committed to helping you achieve your sporting goals. Let's make this journey amazing together! 🌟

Best regards,
PSA Sports Academy Team
                `.trim()
            },

            paymentConfirmation: {
                subject: '✅ Payment Confirmation - PSA Sports Academy',
                greeting: 'Dear {studentName},',
                body: `
Thank you for your payment! Your transaction has been successfully processed. 💳

🧾 *Payment Receipt:*
• Receipt No: {receiptNumber}
• Student: {studentName}
• Amount Paid: ₹{amount}
• Payment Method: {paymentMethod}
• Date: {paymentDate}
• For Period: {paymentPeriod}

Your account is now up to date. You can continue enjoying uninterrupted training sessions.

📱 *Digital Receipt:*
A detailed receipt has been generated and is available for download from your student portal.

For any queries regarding this payment, please contact us with your receipt number.

📞 Contact: +91-XXXXXXXXXX
📧 Email: accounts@psasports.com

Thank you for choosing PSA Sports Academy! 🙏

Best regards,
PSA Sports Academy Team
                `.trim()
            },

            birthdayWish: {
                subject: '🎂 Happy Birthday from PSA Sports Academy!',
                greeting: 'Dear {studentName},',
                body: `
🎉 Happy Birthday, Champion! 🎂

The entire PSA Sports Academy family wishes you a very happy birthday! May this new year of your life be filled with amazing achievements, both on and off the field.

🏆 *Birthday Wishes from:*
• Your Coach {coachName}
• Your teammates in {batchName}
• The entire PSA family

🎁 *Special Birthday Offer:*
As a birthday gift, you get a complimentary extra training session this month! Contact the office to schedule it.

Keep shining and achieving new milestones! We're proud to be part of your sports journey.

Have a fantastic day filled with joy, cake, and celebration! 🎈

With warm birthday wishes,
PSA Sports Academy Team
                `.trim()
            }
        };
    }

    getFeeReminderMessage(student, paymentDetails) {
        const template = this.templates.feeReminder;
        
        const dueDate = moment(paymentDetails.due_date);
        const daysOverdue = moment().diff(dueDate, 'days');
        
        return this.processTemplate(template.body, {
            studentName: student.name,
            sportName: student.sport?.name || 'N/A',
            batchName: student.batch?.name || 'N/A',
            amount: paymentDetails.amount || '0',
            dueDate: dueDate.format('DD MMM YYYY'),
            daysOverdue: Math.max(0, daysOverdue)
        });
    }

    getSessionNotificationMessage(batch, sessionDetails = {}) {
        const template = this.templates.sessionNotification;
        
        const sessionDate = moment(sessionDetails.date || batch.next_session);
        const sessionTime = sessionDetails.time || batch.time;
        
        return this.processTemplate(template.body, {
            sportName: batch.sport?.name || 'N/A',
            batchName: batch.name,
            coachName: batch.coach?.name || 'N/A',
            coachPhone: batch.coach?.phone || 'N/A',
            sessionDate: sessionDate.format('DD MMM YYYY (dddd)'),
            sessionTime: sessionTime,
            venue: sessionDetails.venue || batch.venue || 'PSA Sports Academy',
            duration: sessionDetails.duration || batch.duration || '1 hour',
            specialInstructions: sessionDetails.instructions || 'Please follow all safety guidelines and academy rules.'
        });
    }

    getAttendanceAlertMessage(student, attendanceData) {
        const template = this.templates.attendanceAlert;
        
        const lastAttended = moment(attendanceData.last_attended);
        
        return this.processTemplate(template.body, {
            studentName: student.name,
            sportName: student.sport?.name || 'N/A',
            batchName: student.batch?.name || 'N/A',
            coachName: student.batch?.coach?.name || 'N/A',
            coachPhone: student.batch?.coach?.phone || 'N/A',
            missedSessions: attendanceData.missed_sessions || 0,
            lastAttended: lastAttended.format('DD MMM YYYY'),
            attendanceRate: Math.round(attendanceData.attendance_rate || 0)
        });
    }

    getWelcomeMessage(student, enrollmentDetails) {
        const template = this.templates.welcomeMessage;
        
        const startDate = moment(enrollmentDetails.start_date);
        const firstSessionDate = moment(enrollmentDetails.first_session_date);
        
        return this.processTemplate(template.body, {
            studentName: student.name,
            sportName: student.sport?.name || 'N/A',
            batchName: student.batch?.name || 'N/A',
            coachName: student.batch?.coach?.name || 'N/A',
            coachPhone: student.batch?.coach?.phone || 'N/A',
            startDate: startDate.format('DD MMM YYYY'),
            firstSessionDate: firstSessionDate.format('DD MMM YYYY (dddd)'),
            trainingSchedule: this.formatTrainingSchedule(student.batch)
        });
    }

    getPaymentConfirmationMessage(student, paymentDetails) {
        const template = this.templates.paymentConfirmation;
        
        const paymentDate = moment(paymentDetails.payment_date);
        
        return this.processTemplate(template.body, {
            studentName: student.name,
            receiptNumber: paymentDetails.receipt_number,
            amount: paymentDetails.amount,
            paymentMethod: paymentDetails.payment_method,
            paymentDate: paymentDate.format('DD MMM YYYY'),
            paymentPeriod: paymentDetails.payment_period || 'Current month'
        });
    }

    getBirthdayWishMessage(student) {
        const template = this.templates.birthdayWish;
        
        return this.processTemplate(template.body, {
            studentName: student.name,
            coachName: student.batch?.coach?.name || 'Your Coach',
            batchName: student.batch?.name || 'your batch'
        });
    }

    processTemplate(template, variables) {
        let processed = template;
        
        // Replace variables in the format {variableName}
        Object.keys(variables).forEach(key => {
            const regex = new RegExp(`{${key}}`, 'g');
            processed = processed.replace(regex, variables[key] || 'N/A');
        });
        
        return processed;
    }

    formatTrainingSchedule(batch) {
        if (!batch || !batch.schedule) {
            return 'Schedule will be shared by your coach';
        }
        
        const schedule = batch.schedule;
        let formatted = '';
        
        if (Array.isArray(schedule)) {
            schedule.forEach(session => {
                formatted += `• ${session.day}: ${session.time}\n`;
            });
        } else if (typeof schedule === 'string') {
            formatted = schedule;
        }
        
        return formatted || 'Schedule will be shared by your coach';
    }

    // Custom message builder
    buildCustomMessage(template, variables) {
        return this.processTemplate(template, variables);
    }

    // Get all available templates
    getAvailableTemplates() {
        return Object.keys(this.templates);
    }

    // Get template by name
    getTemplate(templateName) {
        return this.templates[templateName] || null;
    }

    // Add custom template
    addTemplate(name, template) {
        this.templates[name] = template;
    }

    // Validate message length (WhatsApp has character limits)
    validateMessageLength(message) {
        const maxLength = 4096; // WhatsApp message limit
        
        if (message.length > maxLength) {
            return {
                valid: false,
                length: message.length,
                maxLength: maxLength,
                excess: message.length - maxLength
            };
        }
        
        return {
            valid: true,
            length: message.length,
            maxLength: maxLength
        };
    }

    // Truncate message if too long
    truncateMessage(message, maxLength = 4096) {
        if (message.length <= maxLength) {
            return message;
        }
        
        return message.substring(0, maxLength - 3) + '...';
    }
}

module.exports = MessageTemplates;