# PSA Sports Academy Management Suite

A comprehensive Laravel 11 application for managing sports academy operations including student management, fee tracking, coach management, attendance, and more.

## 🚀 Features

### Core Modules
- **Student Management** - Complete student profiles, registration, and tracking
- **Payment Management** - Fee collection, receipt generation, and financial tracking
- **Coach Management** - Coach profiles, specializations, and salary management
- **Sports Management** - Sports categories and activity management
- **Batch Management** - Training batch scheduling and organization
- **Attendance Management** - Student attendance tracking and reporting
- **Inquiry Management** - Lead management and follow-up system

### Technical Features
- **RESTful API** - Complete API with Laravel Sanctum authentication
- **Role-based Access** - Admin, Coach, and Student roles with permissions
- **Responsive Design** - Dark theme with mobile-optimized interface
- **Advanced Search** - Filtering and search across all modules
- **Receipt Generation** - Professional payment receipts with print functionality
- **Statistics Dashboard** - Comprehensive analytics and reporting

## 🛠️ Technology Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum (API) + Laravel Breeze (Web)
- **Authorization**: Spatie Laravel Permission
- **Frontend**: Tailwind CSS, Alpine.js
- **Icons**: Heroicons

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js (for future WhatsApp bot integration)

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/r2w34/PSA-NASHIK.git
   cd PSA-NASHIK/psa-laravel
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   Update your `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=psa_academy
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Start the development server**
   ```bash
   php artisan serve --host=0.0.0.0 --port=51897
   ```

## 👤 Default Login Credentials

After running the seeders, you can login with:
- **Email**: admin@psa.com
- **Password**: password

## 📚 API Documentation

The application includes a comprehensive RESTful API. See `API_DOCUMENTATION.md` for detailed endpoint documentation.

### API Base URL
```
http://localhost:51897/api/v1
```

### Authentication
The API uses Laravel Sanctum for token-based authentication. Include the Bearer token in requests:
```
Authorization: Bearer {your-token-here}
```

## 🔐 Security Features

- Laravel Sanctum token authentication
- Role-based access control
- Input validation and sanitization
- SQL injection protection
- XSS protection
- CSRF protection

## 📋 Project Status

- ✅ **Core Modules**: Student, Payment, Coach, Sports, Batch, Attendance, Inquiry management
- ✅ **API Development**: Complete RESTful API with authentication
- ✅ **UI/UX**: Responsive dark theme with mobile optimization
- 🔄 **In Progress**: WhatsApp bot integration, Installation wizard
- 📋 **Planned**: Advanced reporting, Email notifications, Mobile app

## 📄 Documentation

- `README.md` - This file (project overview and setup)
- `PROJECT_STATUS.md` - Detailed project status and development guide
- `API_DOCUMENTATION.md` - Comprehensive API documentation

## 📞 Support

For support and questions:
- Review the documentation files
- Check the API documentation
- Test functionality in the development environment

---

**Version**: 1.0.0  
**Last Updated**: July 27, 2025  
**Status**: API Development Phase Completed
