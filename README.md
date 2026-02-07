# Allami Homes - Real Estate Management System

A modern PHP-based real estate management application for showcasing luxury apartments with user authentication, image galleries, and feedback system.

## 🚀 Features

- **User Authentication**: Secure login/registration system with role-based access (User/Admin)
- **Image Gallery**: Categorized apartment images (Aerial, Eye Level, Blueprint)
- **Admin Dashboard**: Upload, edit, and delete apartment images
- **Feedback System**: Users can submit feedback, admins can manage it
- **Responsive Design**: Modern dark theme with green accents
- **Secure**: Password hashing, SQL injection protection, session management

## 📋 Prerequisites

- **PHP 8.0+** (You have PHP 8.2.12 ✅)
- **MySQL 5.7+** or **MariaDB**
- **Web Server** (Apache/Nginx) or **XAMPP/WAMP/MAMP**

## 🛠️ Installation & Setup

### Step 1: Database Setup

1. **Start your MySQL server** (via XAMPP, WAMP, or standalone MySQL)

2. **Import the database schema**:
   - Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)
   - Create a new database named `allami_homes`
   - Click on the database, then go to "Import" tab
   - Select `database_schema.sql` file and click "Go"

   **OR** use command line (if MySQL is in PATH):
   ```bash
   mysql -u root -p < database_schema.sql
   ```

### Step 2: Configure Database Connection

The database configuration is already set in `includes/config.php`:
```php
DB_HOST: localhost
DB_NAME: allami_homes
DB_USER: root
DB_PASS: (empty by default)
```

**If your MySQL has a password**, edit `includes/config.php` and update line 6:
```php
define('DB_PASS', 'your_password_here');
```

### Step 3: Create Required Directories

Ensure the `uploads` directory exists and has write permissions:
```bash
mkdir uploads
```

### Step 4: Start the Application

#### Option A: Using PHP Built-in Server (Quick Start)
```bash
php -S localhost:8000
```
Then open: **http://localhost:8000**

#### Option B: Using XAMPP/WAMP
1. Copy the project folder to `htdocs` (XAMPP) or `www` (WAMP)
2. Start Apache and MySQL from the control panel
3. Open: **http://localhost/allami%20homes**

## 👤 Default Access

### Create Admin Account
After importing the database, you can create an admin account:

1. Go to **http://localhost:8000/auth/register.php**
2. Register with your details
3. Manually update the role in database:
   - Open phpMyAdmin
   - Go to `allami_homes` → `users` table
   - Find your user and change `role` from `user` to `admin`

**OR** uncomment line 64 in `database_schema.sql` before importing to create default admin:
- **Username**: admin
- **Email**: admin@allamihomes.com
- **Password**: admin123

## 📁 Project Structure

```
allami homes/
├── auth/                   # Authentication pages
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── includes/               # Shared components
│   ├── config.php         # Database configuration
│   ├── header.php
│   ├── footer.php
│   └── navigation.php
├── uploads/               # User-uploaded images
├── images/                # Static images
├── css/                   # Stylesheets
├── js/                    # JavaScript files
├── index.php              # Landing page
├── dashboard.php          # User dashboard
├── admin-dashboard.php    # Admin panel
├── upload-image.php       # Image upload handler
├── edit-image.php         # Image edit handler
├── delete-image.php       # Image delete handler
├── submit-feedback.php    # Feedback submission
├── delete-feedback.php    # Feedback deletion
└── database_schema.sql    # Database schema
```

## 🔐 Security Features

- ✅ Password hashing with bcrypt
- ✅ Prepared statements (SQL injection protection)
- ✅ Session-based authentication
- ✅ Role-based access control
- ✅ CSRF protection on forms
- ✅ File upload validation

## 🎨 Tech Stack

- **Backend**: PHP 8.2
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Icons**: Font Awesome 6.4.0
- **Design**: Custom dark theme with gradient effects

## 📝 Usage

### For Users:
1. Register an account
2. Login to access the dashboard
3. View apartment galleries (Aerial, Eye Level, Blueprint)
4. Submit feedback

### For Admins:
1. Login with admin credentials
2. Access admin dashboard
3. Upload/edit/delete apartment images
4. Manage user feedback
5. View all system data

## 🐛 Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check credentials in `includes/config.php`
- Ensure database `allami_homes` exists

### Images Not Displaying
- Check `uploads/` directory exists
- Verify write permissions on `uploads/` folder
- Ensure image paths are correct in database

### Session Issues
- Clear browser cookies
- Check PHP session configuration
- Verify `session_start()` is called

## 📄 License

This project is for educational/portfolio purposes.

## 👨‍💻 Developer

Built with ❤️ for modern real estate management
