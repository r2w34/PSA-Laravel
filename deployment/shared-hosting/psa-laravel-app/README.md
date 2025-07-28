# PSA Sports Academy Management Suite

A comprehensive Laravel 11 application for managing sports academies with a modern dark UI theme, built with MySQL backend and designed for both web and future mobile expansion.

## 🏆 Features

### Core Management
- **Student Management**: Complete CRUD operations for student records
- **Fee Management**: Track payments, generate receipts, and manage outstanding fees
- **Coach Management**: Manage coaching staff with specializations and experience tracking
- **Sports & Batches**: Organize sports activities and batch scheduling
- **Attendance Tracking**: Mark and monitor student attendance
- **Inquiry Management**: Lead tracking and conversion management
- **Payment Processing**: Comprehensive payment tracking and receipt generation

### Advanced Features
- **WhatsApp Integration**: Automated messaging for fee reminders and notifications
- **Reports & Analytics**: Comprehensive reporting dashboard
- **Role-based Access**: Admin, Coach, and Student role management
- **Dark Mode Toggle**: Professional dark/light theme switching
- **RESTful API**: Ready for mobile app integration with Passport/Sanctum
- **Installation Wizard**: Easy setup with environment configuration

## 🎨 UI/UX Features

- **Professional Blue Theme**: Modern dark UI with blue accent colors (#3B82F6)
- **Responsive Design**: Works seamlessly across all device sizes
- **Interactive Dashboard**: Real-time statistics and analytics
- **Smooth Animations**: Enhanced user experience with CSS transitions
- **Font Awesome Icons**: Professional iconography throughout
- **Tailwind CSS**: Utility-first CSS framework for consistent styling

## 🛠️ Technology Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Database**: MySQL (SQLite for development)
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Authentication**: Laravel Sanctum/Passport
- **Package Management**: Composer, NPM
- **Build Tools**: Vite
- **Additional**: Spatie Laravel Permission, Activity Log

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+ (or SQLite for development)
- Apache/Nginx web server

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/r2w34/PSA-Laravel.git
cd PSA-Laravel
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build frontend assets
npm run build
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

### 5. Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 🔧 Configuration

### Database Configuration
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=psa_sports_academy
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### WhatsApp Integration
Configure WhatsApp bot settings in `.env`:
```env
WHATSAPP_ENABLED=true
WHATSAPP_SESSION_PATH=storage/whatsapp-session
```

## 👥 Default Users

After running seeders, you can login with:
- **Email**: admin@psa.com
- **Password**: password

## 📱 API Documentation

The application provides RESTful APIs for mobile app integration:
- Base URL: `/api/v1`
- Authentication: Bearer Token (Sanctum)
- All endpoints support JSON responses

## 🎯 Key Features Showcase

### Dashboard
- Real-time statistics and analytics
- Quick action buttons
- Recent activity feed
- Revenue tracking

### Student Management
- Complete student profiles
- Batch assignments
- Fee tracking
- Attendance records

### Fee Management
- Payment tracking
- Receipt generation
- Outstanding fee alerts
- Payment history

### WhatsApp Integration
- Automated fee reminders
- Session notifications
- Bulk messaging
- QR code authentication

## 🔒 Security Features

- Role-based access control
- CSRF protection
- SQL injection prevention
- XSS protection
- Secure authentication

## 📊 Reports & Analytics

- Revenue reports
- Student enrollment trends
- Attendance analytics
- Fee collection reports
- Coach performance metrics

## 🌐 Deployment

### Production Deployment
1. Set up web server (Apache/Nginx)
2. Configure database
3. Set environment variables
4. Run migrations
5. Build assets: `npm run build`
6. Set proper file permissions

### Shared Hosting (cPanel)
The application is optimized for shared hosting deployment with cPanel support.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review the code comments

## 🔄 Version History

- **v1.0.0**: Initial release with core features
- **v1.1.0**: UI improvements and dark mode toggle
- **v1.2.0**: WhatsApp integration and enhanced reporting

---

**PSA Sports Academy Management Suite** - Empowering sports academies with modern technology! 🏆