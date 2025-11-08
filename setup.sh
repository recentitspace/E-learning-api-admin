#!/bin/bash

# Edulab LMS - Secure Setup Script
# This script automates the setup process after security cleanup

echo "🚀 Starting Edulab LMS Setup..."
echo "================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Check if .env file exists
if [ ! -f .env ]; then
    print_warning ".env file not found. Please create it first!"
    echo "Copy the configuration from SETUP_GUIDE.md"
    exit 1
fi

print_status "Found .env file"

# Generate application key if not set
if grep -q "APP_KEY=$" .env; then
    print_status "Generating application key..."
    php artisan key:generate
else
    print_status "Application key already set"
fi

# Create storage link
print_status "Creating storage link..."
php artisan storage:link

# Set proper permissions
print_status "Setting file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Install Node.js dependencies
if [ -f package.json ]; then
    print_status "Installing Node.js dependencies..."
    npm install
    
    print_status "Building frontend assets..."
    npm run build
else
    print_warning "package.json not found, skipping Node.js setup"
fi

# Check database connection
print_status "Checking database connection..."
if php artisan migrate:status > /dev/null 2>&1; then
    print_status "Database connection successful"
    
    # Run migrations
    print_status "Running database migrations..."
    php artisan migrate --force
    
    # Seed database
    print_status "Seeding database with initial data..."
    php artisan db:seed --force
    
else
    print_error "Database connection failed!"
    print_warning "Please check your database configuration in .env"
    exit 1
fi

# Clear and cache configuration
print_status "Optimizing application..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create admin user (optional)
read -p "Do you want to create a new admin user? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan make:command CreateAdminUser --command=make:admin
    print_status "You can now create admin users with: php artisan make:admin"
fi

print_status "Setup completed successfully!"
echo ""
echo "🎉 Edulab LMS is ready to use!"
echo "================================"
echo ""
echo "Next steps:"
echo "1. Configure your web server to point to the 'public' directory"
echo "2. Set up SSL certificate"
echo "3. Change default passwords"
echo "4. Configure mail settings"
echo "5. Set up payment gateways (if needed)"
echo ""
echo "Default login credentials:"
echo "Admin: admin@gmail.com"
echo "Student: student@gmail.com"
echo "Instructor: instructor@gmail.com"
echo "Organization: organization@gmail.com"
echo ""
print_warning "IMPORTANT: Change all default passwords immediately!"
echo ""
echo "For detailed configuration, see SETUP_GUIDE.md"
echo "For security best practices, see SECURITY_CHECKLIST.md" 