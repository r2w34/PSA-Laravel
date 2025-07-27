# 🏆 PSA Sports Academy Management Suite

<div align="center">

![PSA Logo](https://img.shields.io/badge/PSA-Sports%20Academy-purple?style=for-the-badge&logo=data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iOCIgZmlsbD0iIzc5MzNGRiIvPgo8dGV4dCB4PSI1IiB5PSIxNSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjgiIGZvbnQtd2VpZ2h0PSJib2xkIiBmaWxsPSJ3aGl0ZSI+UDwvdGV4dD4KPHRleHQgeD0iMTUiIHk9IjI1IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iOCIgZm9udC13ZWlnaHQ9ImJvbGQiIGZpbGw9IndoaXRlIj5TPC90ZXh0Pgo8dGV4dCB4PSIyNSIgeT0iMzUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSI4IiBmb250LXdlaWdodD0iYm9sZCIgZmlsbD0id2hpdGUiPkE8L3RleHQ+Cjwvc3ZnPgo=)

**A comprehensive Laravel 11 application for complete sports academy management with advanced WhatsApp automation**

[![Laravel](https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat-square&logo=mysql)](https://mysql.com)
[![Node.js](https://img.shields.io/badge/Node.js-16+-green?style=flat-square&logo=node.js)](https://nodejs.org)
[![WhatsApp](https://img.shields.io/badge/WhatsApp-Bot-brightgreen?style=flat-square&logo=whatsapp)](https://whatsapp.com)

[🚀 Quick Start](#-quick-start) • [📱 Features](#-features) • [🤖 WhatsApp Bot](#-whatsapp-bot) • [📚 Documentation](#-documentation) • [🛠️ API](#️-api)

</div>

---

## 🎯 Project Overview

**PSA Sports Academy Management Suite** is a production-ready, enterprise-grade application designed for comprehensive sports academy management. Built with Laravel 11 and featuring advanced WhatsApp automation, it provides everything needed to run a modern sports academy efficiently.

### 🏆 **95% Complete** - Production Ready!

---

## ✨ Features

### 🎓 **Core Management Modules**
- **👥 Student Management** - Complete CRUD with photo uploads, advanced search, and bulk operations
- **💰 Fee & Payment Tracking** - Automated payment tracking, professional PDF receipts, outstanding fee alerts
- **👨‍🏫 Coach Management** - Coach profiles, batch assignments, performance metrics, and scheduling
- **🏃‍♂️ Sports Management** - Multi-sport support (Cricket, Football, Basketball, Tennis, Badminton)
- **👥 Batch Management** - Time-based organization, capacity management, and student assignments
- **📅 Attendance Tracking** - Daily attendance, bulk operations, automated alerts, and comprehensive reporting
- **🔍 Inquiry Management** - Lead tracking, follow-up system, and conversion management

### 🤖 **Advanced WhatsApp Automation**
- **📱 Automated Messaging** - Fee reminders, session notifications, attendance alerts
- **⏰ Smart Scheduling** - Cron-based automated messaging system
- **🎂 Personal Touch** - Birthday wishes, welcome messages, payment confirmations
- **📊 Real-time Monitoring** - Bot status, message queue, and health monitoring
- **🔧 Easy Management** - Web-based bot control panel and CLI commands

### 🎨 **Modern User Interface**
- **🌙 Dark Theme** - Professional purple/dark theme design
- **📱 Responsive Design** - Mobile-first, works perfectly on all devices
- **⚡ Interactive Components** - Dynamic forms, modals, and real-time updates
- **🎯 Role-based Dashboards** - Customized interfaces for Admin, Coach, and Student roles

### 🔐 **Security & Authentication**
- **🛡️ Laravel Breeze** - Secure authentication system
- **👤 Role-based Access** - Spatie Laravel Permission integration
- **🔑 API Authentication** - Laravel Sanctum for mobile app integration
- **🔒 Data Protection** - Encrypted sensitive data and secure sessions

---

## 🚀 Quick Start

### 📋 Prerequisites

```bash
✅ PHP 8.2 or higher
✅ Composer
✅ Node.js 16+ and npm
✅ MySQL 8.0+
✅ Git
```

### ⚡ Installation

1. **📥 Clone the repository**
   ```bash
   git clone https://github.com/r2w34/PSA-NASHIK.git
   cd PSA-NASHIK
   ```

2. **🔧 Setup Laravel Application**
   ```bash
   cd laravel-app
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **🗄️ Configure Database**
   ```bash
   # Edit .env file with your database credentials
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=psa_academy
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   # Run migrations and seed data
   php artisan migrate --seed
   ```

4. **🤖 Setup WhatsApp Bot**
   ```bash
   cd ../whatsapp-bot
   npm install
   cp .env.example .env
   # Configure WhatsApp bot settings in .env
   ```

5. **🚀 Start the Application**
   ```bash
   # Terminal 1: Laravel Application
   cd laravel-app
   php artisan serve --host=0.0.0.0 --port=51897
   
   # Terminal 2: WhatsApp Bot Service
   cd ../whatsapp-bot
   npm start
   ```

6. **🎉 Access the Application**
   - **Web Application**: http://localhost:51897
   - **WhatsApp Bot**: http://localhost:3001

---

## 🔑 Default Login Credentials

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| **Admin** | admin@psa.com | password | Full system access |
| **Coach** | coach@psa.com | password | Student & attendance management |
| **Student** | student@psa.com | password | Personal dashboard & information |

---

## 🤖 WhatsApp Bot Integration

### 📱 **Automated Messaging Features**
- **💰 Fee Reminders** - Automated payment reminders with due dates
- **📅 Session Notifications** - Training session alerts and schedules
- **📊 Attendance Alerts** - Low attendance notifications to parents
- **🎂 Birthday Wishes** - Personalized birthday messages
- **✅ Payment Confirmations** - Receipt confirmations via WhatsApp
- **👋 Welcome Messages** - New student onboarding

### ⏰ **Smart Scheduling**
- **Monday 9:00 AM** - Fee reminders for outstanding payments
- **Daily 8:00 AM** - Session notifications for upcoming training
- **Daily 6:00 PM** - Attendance alerts for low attendance students
- **Daily 10:00 AM** - Birthday wishes for students
- **Every 30 minutes** - Health monitoring and system checks

### 🔧 **Management Interface**
- **Real-time Status** - Bot connection and session monitoring
- **QR Code Authentication** - Easy WhatsApp Web setup
- **Bulk Messaging** - Send messages to multiple recipients
- **Message Templates** - Professional, customizable templates
- **Health Monitoring** - System status and error tracking

---

## 🛠️ API

### 🔗 **RESTful API Endpoints**

The application provides a comprehensive API for mobile app integration:

```bash
# Authentication
POST /api/v1/auth/login
POST /api/v1/auth/register
POST /api/v1/auth/logout

# Students
GET    /api/v1/students
POST   /api/v1/students
GET    /api/v1/students/{id}
PUT    /api/v1/students/{id}
DELETE /api/v1/students/{id}

# Payments
GET    /api/v1/payments
POST   /api/v1/payments
GET    /api/v1/payments/{id}

# Coaches
GET    /api/v1/coaches
GET    /api/v1/coaches/{id}/statistics
```

📖 **Complete API Documentation**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## 📚 Documentation

| Document | Description |
|----------|-------------|
| [📋 FINAL_PROJECT_STATUS.md](FINAL_PROJECT_STATUS.md) | Complete project status and achievements |
| [📖 API_DOCUMENTATION.md](API_DOCUMENTATION.md) | Comprehensive API reference |
| [🤖 whatsapp-bot/README.md](whatsapp-bot/README.md) | WhatsApp bot setup and usage |
| [⚙️ PROJECT_STATUS.md](PROJECT_STATUS.md) | Development progress tracking |

---

## 🏗️ Project Architecture

```
PSA-NASHIK/
├── 🌐 laravel-app/              # Main Laravel 11 Application
│   ├── app/
│   │   ├── Http/Controllers/    # Web & API Controllers
│   │   ├── Models/             # Eloquent Models
│   │   ├── Services/           # Business Logic Services
│   │   └── Console/Commands/   # Artisan Commands
│   ├── database/
│   │   ├── migrations/         # Database Schema
│   │   └── seeders/           # Sample Data
│   ├── resources/views/        # Blade Templates
│   └── routes/                # Web & API Routes
│
├── 🤖 whatsapp-bot/            # Node.js WhatsApp Service
│   ├── src/
│   │   ├── WhatsAppBot.js     # Core Bot Logic
│   │   ├── MessageTemplates.js # Message Templates
│   │   ├── LaravelAPI.js      # Laravel Integration
│   │   └── CronJobs.js        # Automated Scheduling
│   ├── logs/                  # Bot Logs
│   └── sessions/              # WhatsApp Sessions
│
└── 📚 docs/                    # Project Documentation
```

---

## 🎯 Key Achievements

### ✅ **Technical Excellence**
- **Modern Architecture** - Laravel 11 with best practices
- **Clean Code** - Well-structured, maintainable codebase
- **Comprehensive Testing** - Thoroughly tested functionality
- **Performance Optimized** - Fast loading and responsive interface

### 🎨 **User Experience**
- **Intuitive Interface** - User-friendly design and navigation
- **Responsive Design** - Works perfectly on all devices
- **Professional Styling** - Modern dark theme with purple accents
- **Accessibility** - WCAG compliant interface design

### 🔒 **Security & Reliability**
- **Secure Authentication** - Multi-layer security implementation
- **Data Protection** - Encrypted sensitive data storage
- **Error Handling** - Comprehensive error management
- **Backup Systems** - Automated backup and recovery ready

### 📈 **Scalability & Performance**
- **Database Optimization** - Efficient queries and indexing
- **Caching Strategy** - Redis/Memcached ready
- **Queue System** - Background job processing
- **API Rate Limiting** - Prevents system overload

---

## 🚀 Production Deployment

### 🌐 **Shared Hosting (cPanel)**
```bash
# Upload files via File Manager or FTP
# Configure database in cPanel
# Update .env with production settings
# Run migrations via Terminal or cron job
```

### 🐳 **Docker Deployment**
```bash
# Docker configuration ready
# Multi-container setup (Laravel + MySQL + WhatsApp Bot)
# Production-optimized containers
```

### ☁️ **Cloud Deployment**
- **AWS/DigitalOcean** ready
- **Load balancer** compatible
- **Auto-scaling** capable
- **CI/CD pipeline** ready

---

## 🔮 Future Enhancements

### 📱 **Mobile App Integration**
- **Flutter App** - API ready for mobile development
- **Push Notifications** - Real-time mobile notifications
- **Offline Support** - Offline data synchronization

### 🤖 **AI Integration**
- **Chatbot** - AI-powered inquiry handling
- **Predictive Analytics** - Student performance prediction
- **Smart Scheduling** - AI-optimized batch scheduling

### 📊 **Advanced Analytics**
- **Business Intelligence** - Advanced reporting dashboard
- **Performance Metrics** - Detailed analytics and insights
- **Custom Reports** - User-defined report generation

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. **🍴 Fork** the repository
2. **🌿 Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **💾 Commit** your changes (`git commit -m 'Add amazing feature'`)
4. **📤 Push** to the branch (`git push origin feature/amazing-feature`)
5. **🔄 Open** a Pull Request

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 📞 Support & Contact

### 🛠️ **Technical Support**
- **📖 Documentation** - Comprehensive guides and API docs
- **🐛 Issues** - Report bugs via GitHub Issues
- **💬 Discussions** - Community support via GitHub Discussions

### 🚀 **Professional Services**
- **Custom Development** - Feature customization and extensions
- **Deployment Support** - Production deployment assistance
- **Training & Consultation** - System training and best practices

---

<div align="center">

### 🌟 **Star this repository if you find it helpful!**

**Made with ❤️ for Sports Academy Management**

[![GitHub stars](https://img.shields.io/github/stars/r2w34/PSA-NASHIK?style=social)](https://github.com/r2w34/PSA-NASHIK/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/r2w34/PSA-NASHIK?style=social)](https://github.com/r2w34/PSA-NASHIK/network/members)

**Repository**: https://github.com/r2w34/PSA-NASHIK  
**Version**: 1.0.0-rc1  
**Last Updated**: July 27, 2025

</div>