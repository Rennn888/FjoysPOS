# Fjoy's POS - Quick Access Guide

## 🚀 Start the Server

```bash
cd C:\xampp\htdocs\FjoysPOS
start-server.bat
```

## 🔗 Important URLs

### Main Application
- **POS System:** http://localhost:8080/pos
- **Mobile Access:** http://YOUR_IP:8080/pos (replace YOUR_IP with your computer's IP)
- **Diagnostic Tool:** http://localhost:8080/pos/diagnostic

### Management
- **Reset Order Counter:** http://localhost:8080/pos/reset-counter
- **Dashboard:** http://localhost:8080/dashboard

### API Endpoints
- **Products:** http://localhost:8080/api/products
- **Sync Transactions:** http://localhost:8080/api/transactions/sync (POST)
- **Daily Sales:** http://localhost:8080/api/transactions/daily-sales

## 📱 Using the POS

### Taking an Order
1. Tap menu items to add to cart
2. Select flavors when prompted (wings/fries)
3. Adjust quantities with +/- buttons
4. Click "Pay Cash"
5. Enter cash received
6. Complete payment

### Managing Orders
- Click **📋 Orders** button to view active orders
- Click **DONE** on completed orders
- Click **🔄** button to reset counter

### Resetting Order Counter
**When:** Start of each day/shift

**How:**
1. Click 🔄 button in POS header, OR
2. Go to: http://localhost:8080/pos/reset-counter

**What happens:**
- Order number resets to 1
- Active orders cleared
- Transaction history preserved

## 🔧 Configuration

### API Key
File: `.env`
```
API_KEY=Fjoy3211
```

### Database
File: `app/Config/Database.php`
- Default: SQLite (`writable/database.db`)

## 📊 Database Setup

### Run Migrations
```bash
php spark migrate
```

### Seed Menu Data
```bash
php spark db:seed FjoysMenuSeeder
```

## 🎨 Customization

### Menu Items
Edit: `app/Database/Seeds/FjoysMenuSeeder.php`

### Flavors
Edit: `app/Views/pos/index.php`
- Search for `WING_FLAVORS`
- Search for `FRIES_FLAVORS`

### Branding
Edit: `app/Views/pos/index.php`
- Colors: Search for `#dc2626` (red theme)
- Title: Search for `FJOY'S POS`

## 📁 Key Files

```
FjoysPOS/
├── app/
│   ├── Controllers/
│   │   └── Pos.php                    # POS controller
│   ├── Views/
│   │   └── pos/
│   │       ├── index.php              # Main POS interface
│   │       └── reset_counter.php      # Reset page
│   ├── Models/
│   │   ├── ProductModel.php           # Product data
│   │   └── TransactionModel.php       # Transaction data
│   └── Database/
│       └── Seeds/
│           └── FjoysMenuSeeder.php    # Menu items
├── public/
│   └── router.php                     # Server routing
├── start-server.bat                   # Start script
└── .env                               # Configuration
```

## 🆘 Quick Troubleshooting

### Server won't start
```bash
# Check if port 8080 is in use
netstat -an | findstr :8080

# Kill process if needed, then restart
```

### Can't access on mobile
1. Check firewall allows port 8080
2. Verify computer and phone on same network
3. Use correct IP address (not 192.168.254.179 if different)

### Products not showing
```bash
# Re-run seeder
php spark db:seed FjoysMenuSeeder
```

### Order counter stuck
- Go to: http://localhost:8080/pos/reset-counter
- Or clear browser localStorage

## 💡 Tips

- **Offline Mode:** POS works without internet, syncs when online
- **Multiple Devices:** Each device has its own order counter
- **Daily Reset:** Reset counter at start of each day
- **Active Orders:** Use as a simple kitchen display
- **Quick Amounts:** Use ₱50, ₱100, ₱200 buttons for fast payment

## 📞 Support

For issues or questions, check:
- `POS_STRUCTURE.md` - Detailed technical documentation
- `README_POS.md` - Original project overview
- `SETUP_GUIDE.md` - Initial setup instructions
