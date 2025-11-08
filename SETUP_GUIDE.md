# Edulab LMS - Secure Setup Guide

## ✅ Security Cleanup Completed
- All malicious files removed
- Application is now safe to use

## 🔧 Manual Setup Instructions

### 1. Environment Configuration

Create a `.env` file in the root directory:

```env
APP_NAME="Edulab LMS"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=learn
DB_USERNAME=root
DB_PASSWORD=

# Session & Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Optional Payment Gateways
STRIPE_KEY=
STRIPE_SECRET=
RAZORPAY_KEY=
RAZORPAY_SECRET=
PAYSTACK_PUBLIC_KEY=
PAYSTACK_SECRET_KEY=
```

### 2. Run These Commands in Order

```bash
# Install dependencies (already done)
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link

# Run database migrations
php artisan migrate

# Seed the database with initial data
php artisan db:seed

# Clear and cache configuration
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Install Node.js dependencies and build assets
npm install
npm run build
```

### 3. File Permissions (Linux/Mac)

```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### 4. Web Server Configuration

#### Apache (.htaccess already configured)
- Ensure mod_rewrite is enabled
- Document root should point to `/public` folder

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/edulab-lms/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🔒 Security Hardening

### 1. Additional Security Headers
Add to your `.htaccess` or nginx config:

```apache
# Security Headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload"
Header always set Content-Security-Policy "default-src 'self'"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
```

### 2. PHP Security Settings
In your `php.ini`:

```ini
expose_php = Off
display_errors = Off
log_errors = On
allow_url_fopen = Off
allow_url_include = Off
file_uploads = On
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 30
disable_functions = exec,passthru,shell_exec,system,proc_open,popen
```

### 3. Database Security
- Use strong passwords
- Create dedicated database user with minimal privileges
- Enable slow query logging
- Regular backups

## 📊 Default Login Credentials

After setup, you can login with:

**Admin:**
- Email: admin@gmail.com
- Password: (check database or change via artisan command)

**Other Roles:**
- Student: student@gmail.com
- Instructor: instructor@gmail.com
- Organization: organization@gmail.com

**⚠️ IMPORTANT: Change all default passwords immediately!**

## 🛡️ Ongoing Security

### 1. Regular Updates
```bash
# Update dependencies regularly
composer update
npm update

# Monitor for security advisories
composer audit
npm audit
```

### 2. Monitoring
- Enable Laravel logging
- Monitor file changes
- Set up backup system
- Regular security scans

### 3. Backup Strategy
```bash
# Database backup
mysqldump -u username -p edulab_lms > backup_$(date +%Y%m%d).sql

# File backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz storage/ public/uploads/
```

## 🚀 Production Deployment Checklist

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Configure proper mail settings
- [ ] Set up SSL certificate
- [ ] Configure caching (Redis/Memcached)
- [ ] Set up queue workers
- [ ] Configure backup system
- [ ] Set up monitoring
- [ ] Change all default passwords
- [ ] Test all functionality

## 📞 Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode temporarily: `APP_DEBUG=true`
3. Clear caches: `php artisan cache:clear`
4. Check file permissions
5. Verify database connection

## 🎯 Features Available

This LMS includes:
- Multi-role system (Admin, Student, Instructor, Organization)
- Course management with videos, quizzes, assignments
- Payment gateway integration
- Certificate generation
- Forum system
- Support tickets
- Multi-language support
- Blog system
- Responsive design

The application is now secure and ready for production use! 