@echo off
REM Edulab LMS - Secure Setup Script for Windows
REM This script automates the setup process after security cleanup

echo.
echo ========================================
echo   🚀 Starting Edulab LMS Setup...
echo ========================================
echo.

REM Check if .env file exists
if not exist ".env" (
    echo ⚠️  .env file not found!
    echo Please create .env file first using the template in SETUP_GUIDE.md
    pause
    exit /b 1
)

echo ✅ Found .env file

REM Generate application key if not set
findstr /C:"APP_KEY=" .env | findstr /C:"APP_KEY=$" >nul
if %errorlevel% equ 0 (
    echo ✅ Generating application key...
    php artisan key:generate
) else (
    echo ✅ Application key already set
)

REM Create storage link
echo ✅ Creating storage link...
php artisan storage:link

REM Install Node.js dependencies
if exist "package.json" (
    echo ✅ Installing Node.js dependencies...
    npm install
    
    echo ✅ Building frontend assets...
    npm run build
) else (
    echo ⚠️  package.json not found, skipping Node.js setup
)

REM Check database connection and run migrations
echo ✅ Checking database connection...
php artisan migrate:status >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Database connection successful
    
    echo ✅ Running database migrations...
    php artisan migrate --force
    
    echo ✅ Seeding database with initial data...
    php artisan db:seed --force
) else (
    echo ❌ Database connection failed!
    echo ⚠️  Please check your database configuration in .env
    pause
    exit /b 1
)

REM Clear and cache configuration
echo ✅ Optimizing application...
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo ========================================
echo   🎉 Edulab LMS Setup Completed!
echo ========================================
echo.
echo Next steps:
echo 1. Configure your web server to point to the 'public' directory
echo 2. Set up SSL certificate
echo 3. Change default passwords
echo 4. Configure mail settings
echo 5. Set up payment gateways (if needed)
echo.
echo Default login credentials:
echo Admin: admin@gmail.com
echo Student: student@gmail.com
echo Instructor: instructor@gmail.com
echo Organization: organization@gmail.com
echo.
echo ⚠️  IMPORTANT: Change all default passwords immediately!
echo.
echo For detailed configuration, see SETUP_GUIDE.md
echo For security best practices, see SECURITY_CHECKLIST.md
echo.
pause 