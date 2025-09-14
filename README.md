# Royal Palace Gala Dinner Booking System

A complete web-based booking system for the Royal Palace Gala Dinner event, built with PHP and MySQL.

## Features

- **Responsive Design**: Beautiful, mobile-friendly interface
- **Real-time Booking**: Live seat selection and booking system
- **Database Integration**: Full MySQL database integration
- **Admin Dashboard**: Complete admin panel for managing bookings
- **Payment Integration**: Support for multiple payment methods
- **Seat Management**: Visual seating chart with availability tracking

## Database Structure

### Tables

1. **customers** - Customer information
2. **booking_requests** - Booking request details
3. **ticket_purchases** - Ticket purchase records
4. **event_config** - Event configuration and pricing

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Setup Steps

1. **Clone/Download the files** to your web server directory

2. **Create the database**:
   ```sql
   mysql -u root -p < setup_database.sql
   ```

3. **Configure database connection**:
   Edit `config/database.php` and update the database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'royal_gala_db');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

4. **Set file permissions**:
   ```bash
   chmod 755 config/
   chmod 644 config/database.php
   ```

5. **Access the application**:
   - Main booking page: `http://yourdomain.com/index.php`
   - Admin dashboard: `http://yourdomain.com/admin_dashboard.php`

## Usage

### For Customers

1. Visit the main page (`index.php`)
2. Browse event information and pricing
3. Select a table and seat from the seating chart
4. Fill out the booking form
5. Submit the booking request
6. Complete payment using the provided banking details

### For Administrators

1. Access the admin dashboard (`admin_dashboard.php`)
2. Default password: `admin123` (change this in production)
3. View all bookings and their status
4. Update payment status
5. Monitor seat availability
6. View revenue statistics

## File Structure

```
/
├── config/
│   └── database.php          # Database configuration
├── index.php                 # Main booking page
├── process_booking.php       # Booking form handler
├── admin_dashboard.php       # Admin management panel
├── setup_database.sql        # Database setup script
└── README.md                 # This file
```

## API Endpoints

### POST /process_booking.php

Processes booking form submissions.

**Parameters:**
- `firstName` (string, required)
- `lastName` (string, required)
- `email` (string, required)
- `phone` (string, required)
- `address` (string, required)
- `table` (integer, required)
- `seat` (integer, required)
- `payment` (string, required)

**Response:**
```json
{
    "success": true,
    "message": "Booking request submitted successfully",
    "data": {
        "booking_id": 123,
        "purchase_id": 456,
        "payment_reference": "RG000456",
        "amount": 250.00,
        "table_number": 5,
        "seat_number": 3,
        "payment_method": "bank"
    }
}
```

## Security Features

- Input validation and sanitization
- SQL injection prevention using prepared statements
- CSRF protection (implement in production)
- Session management for admin access

## Customization

### Styling
- Modify CSS variables in the `<style>` section of `index.php`
- Update colors, fonts, and layout as needed

### Database
- Modify table structures in `setup_database.sql`
- Update field validations in `process_booking.php`

### Event Configuration
- Update event details in the `event_config` table
- Modify pricing and table arrangements

## Production Deployment

1. **Security**:
   - Change default admin password
   - Implement proper authentication
   - Use HTTPS
   - Validate all inputs

2. **Performance**:
   - Enable PHP OPcache
   - Use database connection pooling
   - Implement caching

3. **Monitoring**:
   - Set up error logging
   - Monitor database performance
   - Track booking metrics

## Support

For technical support or customization requests, contact:
- **Developer**: MZondi Integrated Solutions (Pty) Ltd
- **Website**: https://mzondiintegratedsolutions.co.za

## License

This project is proprietary software developed for the Royal Palace Gala Dinner event.

---

**Note**: This system is designed specifically for the Royal Palace Gala Dinner event. Modify as needed for other events or requirements.