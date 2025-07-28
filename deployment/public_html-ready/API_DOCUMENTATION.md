# PSA Sports Academy Management Suite - API Documentation

## Overview
This document provides comprehensive API documentation for the PSA Sports Academy Management Suite. The API is built using Laravel 11 with Laravel Sanctum for authentication and follows RESTful principles.

## Base URL
```
http://localhost:51897/api/v1
```

## Authentication
The API uses Laravel Sanctum for token-based authentication. Include the Bearer token in the Authorization header for protected routes.

```
Authorization: Bearer {your-token-here}
```

## API Endpoints

### Authentication Endpoints

#### POST /login
Login user and create token
```json
{
  "email": "admin@psa.com",
  "password": "password"
}
```

#### POST /register
Register new user
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "1234567890",
  "password": "password",
  "password_confirmation": "password",
  "role": "admin"
}
```

#### GET /user
Get authenticated user details (Protected)

#### PUT /user/profile
Update user profile (Protected)

#### PUT /user/password
Change user password (Protected)

#### POST /logout
Logout user (Protected)

#### POST /logout-all
Logout from all devices (Protected)

### Student Endpoints

#### GET /students
Get paginated list of students (Protected)
- Query Parameters: search, sport_id, batch_id, status, gender, sort_by, sort_order, per_page

#### POST /students
Create new student (Protected)
```json
{
  "name": "Student Name",
  "email": "student@example.com",
  "phone": "1234567890",
  "date_of_birth": "2000-01-01",
  "gender": "male",
  "address": "Student Address",
  "emergency_contact": "9876543210",
  "sport_id": 1,
  "batch_id": 1,
  "guardian_name": "Guardian Name",
  "guardian_phone": "9876543210",
  "medical_conditions": "None"
}
```

#### GET /students/{id}
Get specific student details (Protected)

#### PUT /students/{id}
Update student (Protected)

#### DELETE /students/{id}
Delete student (Protected)

#### GET /students-statistics
Get student statistics (Protected)

#### GET /students-sports
Get sports list for dropdown (Protected)

#### GET /students-batches
Get batches list for dropdown (Protected)

### Payment Endpoints

#### GET /payments
Get paginated list of payments (Protected)
- Query Parameters: search, student_id, payment_method, status, payment_type, date_from, date_to, amount_min, amount_max

#### POST /payments
Create new payment (Protected)
```json
{
  "student_id": 1,
  "batch_id": 1,
  "amount": 5000,
  "payment_type": "monthly",
  "payment_method": "cash",
  "status": "completed",
  "payment_date": "2025-07-27",
  "description": "Monthly fee payment"
}
```

#### GET /payments/{id}
Get specific payment details (Protected)

#### PUT /payments/{id}
Update payment (Protected)

#### DELETE /payments/{id}
Delete payment (Protected)

#### GET /payments-statistics
Get payment statistics (Protected)

#### GET /payments-student/{studentId}
Get payments for specific student (Protected)

#### GET /payments/{id}/receipt
Get payment receipt data (Protected)

#### GET /payments-students
Get students list for dropdown (Protected)

#### GET /payments-batches
Get batches list for dropdown (Protected)

### Coach Endpoints

#### GET /coaches
Get paginated list of coaches (Protected)
- Query Parameters: search, sport_id, status, specialization, experience_min, experience_max

#### POST /coaches
Create new coach (Protected)
```json
{
  "name": "Coach Name",
  "email": "coach@example.com",
  "phone": "1234567890",
  "sport_id": 1,
  "specialization": "Cricket Batting",
  "experience_years": 5,
  "qualification": "Level 2 Certified",
  "salary": 50000,
  "joining_date": "2025-01-01",
  "address": "Coach Address",
  "emergency_contact": "9876543210",
  "status": "active"
}
```

#### GET /coaches/{id}
Get specific coach details (Protected)

#### PUT /coaches/{id}
Update coach (Protected)

#### DELETE /coaches/{id}
Delete coach (Protected)

#### GET /coaches-statistics
Get coach statistics (Protected)

#### GET /coaches-sports
Get sports list for dropdown (Protected)

### Dashboard Endpoints

#### GET /dashboard-stats
Get comprehensive dashboard statistics (Protected)

#### GET /health
API health check endpoint (Protected)

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // Response data
  }
}
```

### Paginated Response
```json
{
  "success": true,
  "message": "Data retrieved successfully",
  "data": [
    // Array of items
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 75,
    "from": 1,
    "to": 15,
    "has_more_pages": true
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    // Validation errors (if applicable)
  }
}
```

## HTTP Status Codes
- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 404: Not Found
- 422: Validation Error
- 500: Internal Server Error

## Rate Limiting
API requests are throttled to prevent abuse. Default limits apply per user.

## CORS
CORS is configured to allow requests from all origins during development. Update for production use.

## Security Features
- Laravel Sanctum token authentication
- Input validation and sanitization
- SQL injection protection via Eloquent ORM
- XSS protection
- CSRF protection for web routes

## Testing
Use tools like Postman, Insomnia, or curl to test the API endpoints. Ensure you include the Bearer token for protected routes.

## Support
For API support and questions, contact the development team.