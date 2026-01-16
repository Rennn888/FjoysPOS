# Fjoy's POS - CodeIgniter 4 Structure

## Overview
The POS system is now properly integrated into CodeIgniter 4 framework structure, following MVC (Model-View-Controller) pattern.

## File Structure

### Controller
**Location:** `app/Controllers/Pos.php`
- `index()` - Main POS application page
- `resetOrderCounter()` - Reset order counter page/endpoint

### Views
**Location:** `app/Views/pos/`
- `index.php` - Main POS interface (replaces old pos-mobile.html)
- `reset_counter.php` - Order counter reset page

### Routes
**Location:** `app/Config/Routes.php`
```php
$routes->get('pos', 'Pos::index');
$routes->get('pos/reset-counter', 'Pos::resetOrderCounter');
```

## Accessing the POS

### Start Server
```bash
cd C:\xampp\htdocs\FjoysPOS
start-server.bat
```

### URLs
- **Main POS:** `http://localhost:8080/pos`
- **Mobile Access:** `http://YOUR_IP:8080/pos`
- **Reset Counter:** `http://localhost:8080/pos/reset-counter`

## Order Counter Management

### How It Works
- Order numbers start at 1 and increment with each sale
- Counter persists in browser localStorage
- Active orders are stored locally for quick reference

### Resetting the Counter

**Method 1: Via POS Interface**
1. Click the 🔄 button in the POS header
2. Confirm the reset
3. Counter resets to 1, active orders cleared

**Method 2: Direct URL**
- Navigate to: `http://localhost:8080/pos/reset-counter`
- Click "Reset Counter" button

**Method 3: Browser Console**
```javascript
localStorage.setItem('orderCounter', 1);
localStorage.setItem('activeOrders', '[]');
location.reload();
```

### When to Reset
- At the start of each business day
- At the beginning of a new shift
- When starting fresh after closing

### What Gets Reset
✓ Order counter (back to 1)
✓ Active orders display
✗ Transaction history (stays in database)

## Features

### Current Features
- ✅ Product menu with categories
- ✅ Flavor selection (wings & fries)
- ✅ Shopping cart with quantity controls
- ✅ Cash payment processing
- ✅ Active orders tracking
- ✅ Order counter management
- ✅ Offline-first operation
- ✅ Transaction sync to database
- ✅ Philippine Peso (₱) currency

### Active Orders
- Orders appear after payment completion
- Shows order number, time, items, and total
- "DONE" button to mark orders complete
- Persists across page refreshes
- Accessible via 📋 button in header

## CodeIgniter Integration Benefits

### Why This Structure?
1. **Proper MVC Pattern** - Separates logic, presentation, and routing
2. **Framework Features** - Access to CI4 helpers, libraries, and services
3. **Maintainability** - Easier to update and extend
4. **Security** - Built-in CSRF protection and input validation
5. **Scalability** - Can easily add authentication, reporting, etc.

### Using CI4 Features
The view now has access to:
- `base_url()` - Dynamic URL generation
- `getenv()` - Environment variables
- CI4 helpers and libraries
- Database connections
- Session management

## Development Notes

### Adding New Features
1. Add logic to `app/Controllers/Pos.php`
2. Update view in `app/Views/pos/index.php`
3. Add routes in `app/Config/Routes.php`

### Styling
All CSS is embedded in the view file for simplicity. For larger projects, consider:
- Moving CSS to `public/assets/css/pos.css`
- Moving JavaScript to `public/assets/js/pos.js`
- Using CI4's asset helper functions

### API Integration
The POS communicates with backend APIs:
- `GET /api/products` - Load menu items
- `POST /api/transactions/sync` - Save transactions

API key is configured in `.env` file:
```
API_KEY=Fjoy3211
```

## Troubleshooting

### Can't Access POS
- Ensure server is running: `start-server.bat`
- Check URL includes `/pos`: `http://localhost:8080/pos`
- Verify firewall allows port 8080

### Order Counter Not Resetting
- Use the reset page: `/pos/reset-counter`
- Check browser localStorage is enabled
- Try clearing browser cache

### Products Not Loading
- Check API endpoint: `http://localhost:8080/api/products`
- Verify API key in `.env` matches JavaScript
- Run database migrations and seeders

## Next Steps

### Potential Enhancements
- [ ] Move CSS/JS to separate asset files
- [ ] Add user authentication
- [ ] Create admin panel for menu management
- [ ] Add daily sales reports
- [ ] Implement receipt printing
- [ ] Add multiple device support
- [ ] Create inventory tracking
- [ ] Add customer display screen
