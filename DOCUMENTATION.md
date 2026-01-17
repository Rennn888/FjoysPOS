# Fjoy's POS System - Complete Documentation

## 🍗 Overview

Fjoy's POS is a mobile-first Point of Sale system built with CodeIgniter 4. It's designed for food stands and small restaurants, featuring offline-first operation, flavor selection for wings and fries, active order tracking, and cash payment processing.

---

## 🚀 Quick Start

### Start the Server
```bash
cd C:\xampp\htdocs\FjoysPOS
start-server.bat
```

### Access URLs
- **Desktop POS:** http://localhost:8080/pos
- **Mobile POS:** http://YOUR_IP:8080/pos
- **Diagnostic Tool:** http://YOUR_IP:8080/pos/diagnostic
- **Reset Counter:** http://YOUR_IP:8080/pos/reset-counter
- **Dashboard:** http://localhost:8080/dashboard

### First Time Setup
```bash
# Run database migrations
php spark migrate

# Load menu items
php spark db:seed FjoysMenuSeeder
```

---

## 📱 Using the POS

### Taking Orders
1. **Select Items:** Tap menu items to add to cart
2. **Choose Flavors:** Select flavors for wings/fries when prompted
3. **Adjust Quantities:** Use +/- buttons to modify quantities
4. **Process Payment:** Click "Pay Cash", enter amount, complete sale
5. **Track Orders:** Orders appear in Active Orders panel

### Flavor Selection
**Wing Items:**
- Wing Meal: 1 flavor
- Double Wing Meal: 2 flavors  
- Wingmates (6 pcs): 2 flavors
- Triple Feast (12 pcs): 2 flavors
- Wing Fiesta (18 pcs): 4 flavors
- Chicky Bites: 1 flavor

**Wing Flavors:** Salted Egg, Garlic Parmesan, Barbecue Sauce, Soy Garlic, Korean Flavor, Teriyaki, Honey Butter, Lemon Glaze, Sweet Chili, Buffalo

**Fries Flavors:** Cheese, Sour Cream, Barbecue

### Active Orders Management
- **View Orders:** Click 📋 Orders button in header
- **Complete Orders:** Click "DONE" on finished orders
- **Reset Counter:** Click 🔄 button or visit reset page

---

## 🔧 System Architecture

### File Structure
```
FjoysPOS/
├── app/
│   ├── Controllers/
│   │   ├── Pos.php                    # POS controller
│   │   ├── Dashboard.php              # Admin dashboard
│   │   └── Api/
│   │       ├── ProductController.php  # Product API
│   │       └── TransactionController.php # Transaction API
│   ├── Views/
│   │   └── pos/
│   │       ├── index.php              # Main POS interface
│   │       ├── diagnostic.php         # Diagnostic tool
│   │       └── reset_counter.php      # Reset page
│   ├── Models/
│   │   ├── ProductModel.php           # Product data model
│   │   └── TransactionModel.php       # Transaction data model
│   ├── Database/
│   │   ├── Migrations/                # Database structure
│   │   └── Seeds/
│   │       └── FjoysMenuSeeder.php    # Menu items
│   └── Config/
│       ├── Routes.php                 # URL routing
│       ├── Cors.php                   # CORS settings
│       └── Filters.php                # API authentication
├── public/
│   ├── index.php                      # Entry point
│   └── router.php                     # Development server routing
├── start-server.bat                   # Server startup script
└── .env                               # Configuration
```

### Database Tables
**Products Table:**
- id, name, price, category, image_url, is_active, timestamps

**Transactions Table:**
- id, transaction_id, device_id, order_number, items (JSON), subtotal, total, payment_method, cash_received, change_given, transaction_date, synced_at, timestamps

### API Endpoints
- `GET /api/products` - Fetch menu items
- `POST /api/transactions/sync` - Save transactions
- `GET /api/transactions/daily-sales` - Sales reports
- `GET /api/transactions/report` - Detailed reports

---

## ⚙️ Configuration

### Environment Variables (.env)
```bash
# Environment
CI_ENVIRONMENT = development

# Base URL
app.baseURL = 'http://localhost:8080/'

# Database (MySQL)
database.default.hostname = localhost
database.default.database = food_stand_pos
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi

# API Security
API_KEY = Fjoy3211
```

### Menu Customization
Edit `app/Database/Seeds/FjoysMenuSeeder.php` to modify menu items:
```php
$products = [
    [
        'name' => 'Wing Meal (2 pcs + Rice)',
        'price' => 79.00,
        'category' => 'Rice Meals'
    ],
    [
        'name' => 'Chicken Burger',
        'price' => 0.00, // Price to be determined
        'category' => 'Sandwiches'
    ],
    // Add more items...
];
```

**Current Menu Categories:**
- Rice Meals (wing meals with rice)
- Ala Carte Wings (wings without rice, 6-18 pieces)
- Sandwiches (chicken burger, Hungarian sausage in bun)
- Other Favorites (Hungarian sausage w/ rice, fries, chicky bites)
- Drinks (blue lemonade, cucumber juice in 16oz/22oz)
- Dips (garlic mayo, cheese dip)

### Flavor Customization
Edit `app/Views/pos/index.php`:
```javascript
const WING_FLAVORS = [
    'Salted Egg', 'Garlic Parmesan', // Add/remove flavors
];

const FRIES_FLAVORS = [
    'Cheese', 'Sour Cream', 'Barbecue'
];
```

---

## 🎨 Branding & Styling

### Current Theme
- **Colors:** Red theme (#dc2626, #991b1b)
- **Currency:** Philippine Peso (₱)
- **Title:** 🍗 FJOY'S POS
- **Font:** System fonts (-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto)

### Customizing Appearance
All styles are in `app/Views/pos/index.php`. Key elements:
```css
/* Main brand color */
#dc2626

/* Header gradient */
background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);

/* Menu item borders */
border: 2px solid #fecaca;
```

---

## 🔄 Order Counter Management

### How It Works
- Order numbers start at 1 and auto-increment
- Stored in browser localStorage
- Persists across page refreshes
- Each device has independent counter

### Resetting Counter
**Method 1:** Click 🔄 button in POS header
**Method 2:** Visit http://localhost:8080/pos/reset-counter
**Method 3:** Browser console:
```javascript
localStorage.setItem('orderCounter', 1);
localStorage.setItem('activeOrders', '[]');
location.reload();
```

### When to Reset
- Start of business day
- Beginning of new shift
- After closing/reopening

### What Gets Reset
✅ Order counter (back to 1)
✅ Active orders display
❌ Transaction history (preserved in database)

---

## 🛠️ Troubleshooting

### "No Products Available" on Mobile

**Quick Fix:**
1. Visit: http://YOUR_IP:8080/pos/diagnostic
2. Click "Test API Connection"
3. Check results (green = good, red = problem)

**Common Issues:**

**Server Not Running**
```bash
start-server.bat
```

**Wrong IP Address**
```bash
# Find your IP
ipconfig
# Use that IP: http://192.168.X.X:8080/pos
```

**No Products in Database**
```bash
php spark db:seed FjoysMenuSeeder
```

**Firewall Blocking**
- Allow port 8080 in Windows Firewall
- Or temporarily disable firewall to test

### API Connection Issues

**Test API Directly:**
```bash
# Should return JSON with products
curl -H "X-API-Key: Fjoy3211" http://localhost:8080/api/products
```

**Check API Key:**
Verify `.env` file has:
```
API_KEY = Fjoy3211
```

### Mobile Access Problems

**Requirements:**
- Computer and mobile on same WiFi network
- Port 8080 open in firewall
- Server running with `start-server.bat`

**Testing Steps:**
1. Works on desktop? http://localhost:8080/pos
2. API returns data? http://localhost:8080/api/products
3. Diagnostic passes? http://YOUR_IP:8080/pos/diagnostic
4. Same network? Check WiFi names match

---

## 🔒 Security

### API Authentication
- All API endpoints require `X-API-Key` header
- Key configured in `.env` file
- Filter applied to all `/api/*` routes

### CORS Configuration
- Allows all origins (`*`) for development
- Configured in `app/Config/Cors.php`
- Applied globally via filters

### Data Storage
- Transactions stored in database
- Local storage used for cart and active orders
- No sensitive data in localStorage

---

## 📊 Features

### Current Features
✅ **Product Menu** - Categorized items with prices
✅ **Flavor Selection** - Multi-flavor support for wings/fries
✅ **Shopping Cart** - Add/remove items, quantity controls
✅ **Cash Payments** - Quick amount buttons, change calculation
✅ **Active Orders** - Track orders until completion
✅ **Order Counter** - Auto-incrementing order numbers
✅ **Offline Operation** - Works without internet
✅ **Transaction Sync** - Saves to database when online
✅ **Mobile Optimized** - Touch-friendly interface
✅ **Admin Dashboard** - Sales reports and management

### Potential Enhancements
- [ ] Receipt printing
- [ ] Digital payments (GCash, PayMaya)
- [ ] Inventory tracking
- [ ] Customer display screen
- [ ] Kitchen display system
- [ ] Multi-device sync
- [ ] User authentication
- [ ] Advanced reporting
- [ ] Loyalty program
- [ ] Table management

---

## 🗄️ Database Management

### Migrations
```bash
# Check migration status
php spark migrate:status

# Run pending migrations
php spark migrate

# Rollback migrations
php spark migrate:rollback

# Refresh (rollback + migrate)
php spark migrate:refresh
```

### Seeders
```bash
# Load menu items
php spark db:seed FjoysMenuSeeder

# Load specific seeder
php spark db:seed ProductSeeder
```

### Backup & Restore
```bash
# Backup (if using MySQL)
mysqldump -u root -p food_stand_pos > backup.sql

# Restore
mysql -u root -p food_stand_pos < backup.sql
```

---

## 🚀 Deployment

### Development Server
```bash
# Current method (PHP built-in server)
cd public
php -S 0.0.0.0:8080 router.php
```

### Production Deployment
1. **Web Server:** Apache/Nginx
2. **Database:** MySQL/PostgreSQL
3. **SSL Certificate:** For HTTPS
4. **Environment:** Set `CI_ENVIRONMENT = production`
5. **Security:** Change API key, enable CSRF protection

### Environment Setup
```bash
# Production .env
CI_ENVIRONMENT = production
app.baseURL = 'https://yourdomain.com/'
API_KEY = your-secure-random-key-here
```

---

## 📞 Support & Maintenance

### Log Files
- **Location:** `writable/logs/log-YYYY-MM-DD.log`
- **Debug Bar:** `writable/debugbar/`
- **Check for errors:** Look for ERROR, CRITICAL entries

### Performance Monitoring
- Enable debug toolbar in development
- Monitor database query performance
- Check memory usage for large transactions

### Regular Maintenance
- **Daily:** Reset order counter
- **Weekly:** Check log files for errors
- **Monthly:** Database backup
- **Quarterly:** Update CodeIgniter framework

### Getting Help
1. Check diagnostic page: `/pos/diagnostic`
2. Review log files in `writable/logs/`
3. Test API endpoints directly
4. Verify database has products
5. Check network connectivity

---

## 📝 Development Notes

### Adding New Menu Items
1. Edit `app/Database/Seeds/FjoysMenuSeeder.php`
2. Run: `php spark db:seed FjoysMenuSeeder`
3. Refresh POS page

### Modifying Flavors
1. Edit `app/Views/pos/index.php`
2. Update `WING_FLAVORS` or `FRIES_FLAVORS` arrays
3. Refresh POS page

### Adding New Features
1. **Controller:** Add logic to `app/Controllers/Pos.php`
2. **View:** Update `app/Views/pos/index.php`
3. **Routes:** Add routes in `app/Config/Routes.php`
4. **API:** Create endpoints in `app/Controllers/Api/`

### Code Structure
- **MVC Pattern:** Models, Views, Controllers separated
- **API First:** Frontend communicates via REST API
- **Responsive Design:** Mobile-first CSS
- **Progressive Enhancement:** Works offline, syncs online

---

## 🎯 Business Usage

### Daily Operations
1. **Start of Day:** Reset order counter
2. **Taking Orders:** Use POS interface
3. **Order Tracking:** Monitor active orders
4. **End of Day:** Check sales reports

### Sales Reporting
- **Dashboard:** http://localhost:8080/dashboard
- **Daily Sales:** View transaction summaries
- **Product Performance:** See popular items
- **Payment Tracking:** Monitor cash flow

### Multi-Device Setup
- Each device maintains independent order counter
- All transactions sync to central database
- Reports combine data from all devices

This documentation covers everything you need to know about Fjoy's POS system. For specific technical issues, use the diagnostic tool at `/pos/diagnostic`.