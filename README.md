# Fjoy's POS System

A mobile-first Point of Sale system built with CodeIgniter 4 for food stands and small restaurants.

## 🚀 Quick Start

```bash
# Start the server
start-server.bat

# Access POS
# Desktop: http://localhost:8080/pos
# Mobile: http://YOUR_IP:8080/pos
```

## 📖 Complete Documentation

**[📚 DOCUMENTATION.md](DOCUMENTATION.md)** - Everything you need to know about the system

## 🔧 First Time Setup

```bash
# Run database migrations
php spark migrate

# Load menu items  
php spark db:seed FjoysMenuSeeder
```

## 🆘 Troubleshooting

If you see "No Products Available":
1. Visit: http://YOUR_IP:8080/pos/diagnostic
2. Check what's failing (red = problem)
3. Follow the diagnostic suggestions

## 📁 Key Files

- `start-server.bat` - Start the development server
- `DOCUMENTATION.md` - Complete system documentation
- `app/Views/pos/index.php` - Main POS interface
- `app/Database/Seeds/FjoysMenuSeeder.php` - Menu items
- `.env` - Configuration (API key, database)

## 🍗 Features

- Mobile-optimized POS interface
- Flavor selection for wings and fries
- Active order tracking
- Cash payment processing
- Offline-first operation
- Admin dashboard with reports

Built for Fjoy's food stand with ❤️

---

## CodeIgniter 4 Framework

This project is built on CodeIgniter 4, a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

### Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- json (enabled by default)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) for MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) for HTTP requests