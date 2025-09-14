-- Royal Gala Database Setup
-- Run this SQL script to create the database and tables

CREATE DATABASE IF NOT EXISTS royal_gala_db;
USE royal_gala_db;

-- Customers table
CREATE TABLE IF NOT EXISTS customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Event configuration table
CREATE TABLE IF NOT EXISTS event_config (
    config_id INT AUTO_INCREMENT PRIMARY KEY,
    total_tables INT NOT NULL DEFAULT 20,
    seats_per_table INT NOT NULL DEFAULT 10,
    vip_tables VARCHAR(50) NOT NULL DEFAULT '3-4',
    royalty_tables VARCHAR(50) NOT NULL DEFAULT '1-2',
    general_tables VARCHAR(50) NOT NULL DEFAULT '5-20',
    vip_price DECIMAL(10,2) NOT NULL DEFAULT 500.00,
    general_price DECIMAL(10,2) NOT NULL DEFAULT 250.00,
    event_date DATE NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Booking requests table
CREATE TABLE IF NOT EXISTS booking_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    table_number INT NOT NULL,
    seat_number INT NOT NULL,
    payment_method ENUM('ozow', 'card', 'bank') NOT NULL,
    payment_status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Ticket purchases table
CREATE TABLE IF NOT EXISTS ticket_purchases (
    purchase_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    table_number INT NOT NULL,
    seat_number INT NOT NULL,
    payment_method ENUM('ozow', 'card', 'bank') NOT NULL,
    payment_status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    payment_reference VARCHAR(50) UNIQUE,
    amount_paid DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Insert default event configuration
INSERT INTO event_config (
    total_tables, 
    seats_per_table, 
    vip_tables, 
    royalty_tables, 
    general_tables, 
    vip_price, 
    general_price, 
    event_date
) VALUES (
    20, 
    10, 
    '3-4', 
    '1-2', 
    '5-20', 
    500.00, 
    250.00, 
    '2025-12-12'
) ON DUPLICATE KEY UPDATE last_updated = CURRENT_TIMESTAMP;

-- Create indexes for better performance
CREATE INDEX idx_customers_email ON customers(email);
CREATE INDEX idx_booking_requests_email ON booking_requests(email);
CREATE INDEX idx_ticket_purchases_customer ON ticket_purchases(customer_id);
CREATE INDEX idx_ticket_purchases_table_seat ON ticket_purchases(table_number, seat_number);
CREATE INDEX idx_ticket_purchases_status ON ticket_purchases(payment_status);
CREATE INDEX idx_booking_requests_status ON booking_requests(payment_status);