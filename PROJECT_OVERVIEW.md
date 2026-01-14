# Food Stand POS System - Project Overview

## 🎯 Project Goal

A mobile-first, offline-capable Point of Sale system for food stands that works reliably even without internet connection, with automatic synchronization when online.

## 🏗️ Architecture

### Backend (CodeIgniter 4)
- **Framework:** CodeIgniter 4 (PHP 8.1+)
- **Database:** MySQL/MariaDB
- **API:** RESTful JSON API with API key authentication
- **Purpose:** Centralized data storage, reporting, and synchronization

### Frontend (Progressive Web App)
- **Technology:** Vanilla JavaScript, HTML5, CSS3
- **Storage:** IndexedDB for offline data persistence
- **Service Worker:** Enables offline functionality and app installation
- **UI:** Touch-optimized, mobile-first design

## 📁 Project Structure

```
food-stand-pos/
├── app/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── ProductController.php      # Product API endpoints
│   │   │   └── TransactionController.php  # Transaction sync & reports
│   │   ├── Dashboard.php                  # Admin dashboard
│   │   └── Home.php                       # Redirects to dashboard
│   ├── Models/
│   │   ├── ProductModel.php               # Product data model
│   │   └── TransactionModel.php           # Transaction data model
│   ├── Filters/
│   │   └── ApiAuthFilter.php              # API authentication
│   ├── Database/
│   │   ├── Migrations/
│   │   │   ├── *_CreateProductsTable.php
│   │   │   └── *_CreateTransactionsTable.php
│   │   └── Seeds/
│   │       └── ProductSeeder.php          # Sample menu data
│   ├── Views/
│   │   ├── dashboard.php                  # Main dashboard
│   │   ├── products.php                   # Product management
│   │   └── reports.php                    # Sales reports
│   └── Config/
│       ├── Routes.php                     # URL routing
│       └── Filters.php                    # Filter configuration
├── public/
│   ├── pos.html                           # POS application UI
│   ├── pos-app.js                         # POS application logic
│   ├── sw.js                              # Service worker
│   ├── manifest.json                      # PWA manifest
│   └── test-api.html                      # API testing tool
├── .env                                   # Environment configuration
├── QUICK_START.md                         # 5-minute setup guide
├── SETUP_GUIDE.md                         # Detailed setup instructions
├── README_POS.md                          # POS system documentation
└── PROJECT_OVERVIEW.md                    # This file
```

## 🗄️ Database Schema

### Products Table
```sql
- id (INT, PRIMARY KEY)
- name (VARCHAR)
- price (DECIMAL)
- category (VARCHAR)
- image_url (VARCHAR, nullable)
- is_active (TINYINT)
- created_at (DATETIME)
- updated_at (DATETIME)
```

### Transactions Table
```sql
- id (INT, PRIMARY KEY)
- transaction_id (VARCHAR, UNIQUE)
- device_id (VARCHAR)
- items (TEXT, JSON)
- subtotal (DECIMAL)
- total (DECIMAL)
- payment_method (VARCHAR)
- cash_received (DECIMAL)
- change_given (DECIMAL)
- transaction_date (DATETIME)
- synced_at (DATETIME)
- created_at (DATETIME)
```

## 🔌 API Endpoints

### Authentication
All endpoints require `X-API-Key` header.

### Products
- `GET /api/products` - List all active products
- `GET /api/products/{id}` - Get single product

### Transactions
- `POST /api/transactions/sync` - Sync offline transactions
- `GET /api/transactions/daily-sales?date=YYYY-MM-DD` - Daily sales summary
- `GET /api/transactions/report?start_date=X&end_date=Y` - Sales report

## 🔄 Data Flow

### Online Mode
1. Cashier selects items in POS
2. Completes payment
3. Transaction saved to IndexedDB
4. Immediately synced to server via API
5. Server stores in MySQL database

### Offline Mode
1. Cashier selects items in POS
2. Completes payment
3. Transaction saved to IndexedDB with `synced: false`
4. POS continues working normally
5. When connection restored, auto-sync every 30 seconds
6. Transactions marked as synced after successful upload

## 💡 Key Features

### Offline-First Design
- Menu cached in IndexedDB
- Transactions saved locally
- Automatic background sync
- Visual online/offline indicator

### Touch-Optimized UI
- Large, tap-friendly buttons
- Responsive grid layout
- Quick quantity adjustments
- Fast cash payment workflow

### Cash Payment System
- Quick amount buttons ($5, $10, $20, $50, $100)
- Exact amount button
- Automatic change calculation
- Simple, fast checkout

### Admin Dashboard
- Today's sales summary
- Recent transactions list
- Product management
- Date-range sales reports

### Progressive Web App
- Installable on Android home screen
- Full-screen standalone mode
- Works like native app
- Offline capability

## 🔒 Security Features

- API key authentication
- Environment-based configuration
- Input validation
- SQL injection protection (via CodeIgniter)
- XSS protection (via CodeIgniter)

## 📊 Reporting Capabilities

### Dashboard
- Today's total sales
- Today's transaction count
- Total products
- Recent transactions

### Reports
- Date range filtering
- Total sales summary
- Transaction count
- Average transaction value
- Detailed transaction list

## 🚀 Deployment Options

### Development
```bash
php spark serve --host=0.0.0.0
```

### Production
- Apache with mod_rewrite
- Nginx with PHP-FPM
- Docker container
- Cloud platforms (DigitalOcean, AWS, etc.)

## 🔮 Future Enhancements

### Phase 2 (Multi-Branch)
- Branch identification
- Centralized multi-branch reporting
- Branch-specific product lists
- Consolidated inventory

### Phase 3 (Advanced Features)
- Digital payment integration (Stripe, PayPal)
- Receipt printing (Bluetooth/USB printers)
- Customer display screen
- Kitchen display system
- Order queue management

### Phase 4 (Analytics)
- Sales trends and charts
- Popular items analysis
- Peak hours identification
- Inventory forecasting
- Employee performance tracking

### Phase 5 (Inventory)
- Stock level tracking
- Low stock alerts
- Automatic reorder points
- Supplier management
- Purchase order system

## 🛠️ Technology Stack

### Backend
- **PHP:** 8.1+
- **Framework:** CodeIgniter 4
- **Database:** MySQL 5.7+ / MariaDB 10.3+
- **API:** RESTful JSON

### Frontend
- **JavaScript:** ES6+ (Vanilla)
- **Storage:** IndexedDB
- **PWA:** Service Workers, Web App Manifest
- **CSS:** Modern CSS3 (Grid, Flexbox)

### Development Tools
- **Composer:** Dependency management
- **PHP Spark:** CLI tool
- **Git:** Version control

## 📱 Device Requirements

### POS Device (Android)
- Android 7.0+ (Nougat)
- Chrome browser 67+
- 1GB RAM minimum
- 100MB storage space
- Touch screen

### Server
- PHP 8.1+
- MySQL 5.7+ / MariaDB 10.3+
- 512MB RAM minimum
- 1GB storage minimum
- Apache/Nginx web server

## 🎓 Learning Resources

### CodeIgniter 4
- Official Docs: https://codeigniter.com/user_guide/
- Database: https://codeigniter.com/user_guide/database/
- RESTful API: https://codeigniter.com/user_guide/incoming/restful.html

### Progressive Web Apps
- MDN PWA Guide: https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps
- IndexedDB: https://developer.mozilla.org/en-US/docs/Web/API/IndexedDB_API
- Service Workers: https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API

## 📝 Development Notes

### Code Style
- PSR-12 coding standard for PHP
- Camel case for JavaScript
- Descriptive variable names
- Comments for complex logic

### Testing Strategy
- Manual testing via `test-api.html`
- Browser console for frontend debugging
- Server logs for backend issues
- Real device testing for PWA features

### Version Control
- Git for source control
- Semantic versioning (v1.0.0)
- Feature branches for new development
- Main branch for production-ready code

## 🤝 Contributing

### Adding Features
1. Create feature branch
2. Implement and test
3. Update documentation
4. Submit for review

### Reporting Issues
- Check logs first
- Provide reproduction steps
- Include error messages
- Note environment details

## 📄 License

This project is built on CodeIgniter 4 (MIT License).

## 🎉 Credits

- **Framework:** CodeIgniter 4 Team
- **Design:** Custom mobile-first UI
- **Architecture:** Offline-first PWA pattern

---

**Version:** 1.0.0  
**Last Updated:** January 14, 2025  
**Status:** Production Ready
