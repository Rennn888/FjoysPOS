# Food Stand POS - Complete Setup Guide

## Prerequisites

- PHP 8.1 or higher
- MySQL/MariaDB database
- Composer
- Web server (Apache/Nginx) or use PHP built-in server
- Android device with Chrome browser (for POS app)

## Step-by-Step Setup

### 1. Install Dependencies

```bash
composer install
```

### 2. Configure Database

Edit `.env` file and update database credentials:

```env
database.default.hostname = localhost
database.default.database = food_stand_pos
database.default.username = your_username
database.default.password = your_password
```

### 3. Create Database

```sql
CREATE DATABASE food_stand_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

### 4. Run Migrations

```bash
php spark migrate
```

This creates:
- `products` table - stores menu items
- `transactions` table - stores sales records

### 5. Seed Sample Data

```bash
php spark db:seed ProductSeeder
```

This adds sample products:
- Burger ($5.99)
- Hot Dog ($3.99)
- Fries ($2.99)
- Soda ($1.99)
- Water ($1.00)
- Taco ($4.50)

### 6. Configure API Security

**Important:** Change the default API key!

1. Edit `.env`:
```env
API_KEY = your-unique-secret-key-here
```

2. Edit `public/pos-app.js` (line 3):
```javascript
const API_KEY = 'your-unique-secret-key-here';
```

Both must match!

### 7. Start Development Server

```bash
php spark serve --host=0.0.0.0 --port=8080
```

The `--host=0.0.0.0` allows access from other devices on your network.

### 8. Access the System

**Admin Dashboard:**
```
http://localhost:8080/dashboard
```

**POS Application:**
```
http://localhost:8080/pos.html
```

## Installing POS on Android Device

### Method 1: Add to Home Screen (Recommended)

1. Open Chrome on your Android device
2. Navigate to `http://YOUR_SERVER_IP:8080/pos.html`
3. Tap the menu (⋮) in the top-right corner
4. Select "Add to Home screen"
5. Name it "Food Stand POS"
6. Tap "Add"
7. The app icon will appear on your home screen
8. Open it for full-screen, app-like experience

### Method 2: Install as PWA

1. Open the POS URL in Chrome
2. Look for the "Install" prompt at the bottom
3. Tap "Install"
4. The app will be installed as a standalone application

## Testing Offline Functionality

1. Open POS app on Android
2. Add items to cart and complete a sale
3. Turn on Airplane Mode
4. Continue making sales - they save locally
5. Turn off Airplane Mode
6. Sales automatically sync to server within 30 seconds

## Production Deployment

### 1. Use HTTPS

PWA features require HTTPS in production. Options:
- Use Let's Encrypt for free SSL certificates
- Use a reverse proxy (nginx) with SSL
- Deploy to a platform with built-in SSL (Heroku, DigitalOcean, etc.)

### 2. Update Base URL

Edit `.env`:
```env
app.baseURL = 'https://yourdomain.com/'
```

Edit `public/pos-app.js`:
```javascript
const API_BASE_URL = 'https://yourdomain.com';
```

### 3. Secure API Key

Generate a strong random API key:
```bash
php -r "echo bin2hex(random_bytes(32));"
```

Update both `.env` and `pos-app.js` with this key.

### 4. Set Production Environment

Edit `.env`:
```env
CI_ENVIRONMENT = production
```

### 5. Configure Web Server

**Apache (.htaccess already included):**
- Point document root to `public/` folder
- Enable mod_rewrite

**Nginx:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/project/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## Adding Custom Products

### Via Database

```sql
INSERT INTO products (name, price, category, is_active, created_at) 
VALUES ('Pizza Slice', 4.99, 'Main', 1, NOW());
```

### Via PHP Spark Console

```bash
php spark
```

```php
$db = \Config\Database::connect();
$db->table('products')->insert([
    'name' => 'Pizza Slice',
    'price' => 4.99,
    'category' => 'Main',
    'is_active' => 1,
    'created_at' => date('Y-m-d H:i:s')
]);
```

## Troubleshooting

### POS App Not Loading Menu

**Check:**
1. API key matches in `.env` and `pos-app.js`
2. Database connection is working
3. Products exist in database: `SELECT * FROM products;`
4. Browser console for JavaScript errors (F12)

### Transactions Not Syncing

**Check:**
1. Device has internet connection
2. API endpoint is accessible: `http://your-server/api/products`
3. API key is correct
4. Check browser console for sync errors
5. Server logs: `writable/logs/`

### CORS Issues

If accessing from different domain, add to `app/Config/Cors.php`:

```php
public array $default = [
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
];
```

### Database Connection Failed

**Check:**
1. MySQL service is running
2. Database exists
3. Credentials in `.env` are correct
4. User has proper permissions

```sql
GRANT ALL PRIVILEGES ON food_stand_pos.* TO 'your_username'@'localhost';
FLUSH PRIVILEGES;
```

## API Endpoints Reference

All endpoints require `X-API-Key` header.

### Products

**Get all products:**
```
GET /api/products
```

**Get single product:**
```
GET /api/products/{id}
```

### Transactions

**Sync transactions:**
```
POST /api/transactions/sync
Content-Type: application/json

{
  "transactions": [
    {
      "transaction_id": "TXN-123",
      "device_id": "DEVICE-456",
      "items": [...],
      "subtotal": 10.00,
      "total": 10.00,
      "payment_method": "cash",
      "cash_received": 20.00,
      "change_given": 10.00,
      "transaction_date": "2025-01-14T10:30:00Z"
    }
  ]
}
```

**Get daily sales:**
```
GET /api/transactions/daily-sales?date=2025-01-14
```

**Get sales report:**
```
GET /api/transactions/report?start_date=2025-01-01&end_date=2025-01-14
```

## Backup Strategy

### Database Backup

```bash
# Daily backup
mysqldump -u username -p food_stand_pos > backup_$(date +%Y%m%d).sql

# Restore
mysql -u username -p food_stand_pos < backup_20250114.sql
```

### Automated Backup (Cron)

```bash
# Add to crontab
0 2 * * * mysqldump -u username -p'password' food_stand_pos > /backups/pos_$(date +\%Y\%m\%d).sql
```

## Support & Maintenance

### View Logs

```bash
tail -f writable/logs/log-*.log
```

### Clear Cache

```bash
php spark cache:clear
```

### Database Status

```bash
php spark db:table products
php spark db:table transactions
```

## Next Steps

1. Customize product list for your menu
2. Test offline functionality thoroughly
3. Train staff on POS usage
4. Set up regular database backups
5. Monitor sales through dashboard
6. Consider adding receipt printing
7. Implement inventory tracking (future enhancement)

## Getting Help

- Check logs in `writable/logs/`
- Review browser console (F12) for frontend errors
- Test API endpoints with Postman or curl
- Verify database connectivity
- Check file permissions on `writable/` folder

For CodeIgniter 4 documentation: https://codeigniter.com/user_guide/
