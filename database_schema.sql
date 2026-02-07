-- ============================================
-- Allami Homes Database Schema
-- ============================================
-- Database: allami_homes
-- Description: SQL schema for the Allami Homes real estate management application
-- ============================================

-- Create database
CREATE DATABASE IF NOT EXISTS allami_homes;
USE allami_homes;

-- ============================================
-- Table: users
-- Description: Stores user account information for authentication and authorization
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: apartment_images
-- Description: Stores apartment images organized by category and slot number
-- ============================================
CREATE TABLE IF NOT EXISTS apartment_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('aerial', 'eyelevel', 'blueprint') NOT NULL,
    slot_number INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_category_slot (category, slot_number),
    INDEX idx_category (category),
    INDEX idx_slot_number (slot_number),
    CONSTRAINT chk_slot_number CHECK (slot_number >= 1 AND slot_number <= 19)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: feedback
-- Description: Stores user feedback messages
-- ============================================
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Insert default admin user (optional)
-- Password: admin123 (hashed with bcrypt)
-- ============================================
-- Uncomment the following line to create a default admin account
-- INSERT INTO users (username, email, password, role) 
-- VALUES ('admin', 'admin@allamihomes.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- ============================================
-- Sample data for testing (optional)
-- ============================================

-- Sample users
-- INSERT INTO users (username, email, password, role) VALUES
-- ('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
-- ('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Sample apartment images
-- INSERT INTO apartment_images (category, slot_number, image_path) VALUES
-- ('aerial', 1, 'aerial_1.jpg'),
-- ('aerial', 2, 'aerial_2.jpg'),
-- ('eyelevel', 1, 'eyelevel_1.jpg'),
-- ('eyelevel', 2, 'eyelevel_2.jpg'),
-- ('blueprint', 1, 'blueprint_1.jpg'),
-- ('blueprint', 2, 'blueprint_2.jpg');

-- Sample feedback (requires user_id from users table)
-- INSERT INTO feedback (user_id, message) VALUES
-- (1, 'Great apartments! Love the modern design.'),
-- (2, 'The virtual tour was very helpful.');

-- ============================================
-- Useful Queries
-- ============================================

-- Get all images by category
-- SELECT * FROM apartment_images WHERE category = 'aerial' ORDER BY slot_number;

-- Get all feedback with user information
-- SELECT f.id, f.message, f.created_at, u.username, u.email 
-- FROM feedback f 
-- JOIN users u ON f.user_id = u.id 
-- ORDER BY f.created_at DESC;

-- Count images per category
-- SELECT category, COUNT(*) as image_count 
-- FROM apartment_images 
-- GROUP BY category;

-- Get admin users
-- SELECT * FROM users WHERE role = 'admin';

-- ============================================
-- Database Maintenance
-- ============================================

-- Optimize tables
-- OPTIMIZE TABLE users, apartment_images, feedback;

-- Check table status
-- SHOW TABLE STATUS;

-- Backup command (run from command line)
-- mysqldump -u root -p allami_homes > allami_homes_backup.sql

-- Restore command (run from command line)
-- mysql -u root -p allami_homes < allami_homes_backup.sql
