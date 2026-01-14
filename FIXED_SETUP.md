# Fixed Setup Instructions

## 🔧 The Problem

When running `php -S 192.168.254.179:8080` from the `public` folder, CodeIgniter routing doesn't work properly, so the API endpoints fail.

## ✅ The Solution

Use the proper CodeIgniter server command with the router file.

## 📝 Step-by-Step Fix

### 1. Stop Current Server
Press `Ctrl+C` in your terminal

### 2. Start Server Properly

**Option A: Use the batch file (Easiest)**
```bash
# Double-click this file:
start-server.bat
```

**Option B: Manual command**
```bash
cd C:\xampp\htdocs\FjoysPOS
php spark serve --host=0.0.0.0 --port=8080
```

### 3. Verify Database Setup

```bash
# Check if migrations ran
php spark migrate:status

# If not, run them:
php spark migrate

# Add sample products:
php spark db:seed ProductSeeder
```

### 4. Test API

Open in browser:
```
http://localhost:8080/api/products
```

Should return JSON with products.

### 5. Access POS on Mobile

```
http://192.168.254.179:8080/pos-mobile.html
```

OR use the clean URL:
```
http://192.168.254.179:8080/pos
```

## 🎯 Why This Works

- `php spark serve` uses CodeIgniter's router
- Routes work properly (`/api/products`, `/pos`, etc.)
- API authentication works
- Database connections work
- Everything is properly configured

## 🧪 Quick Test

1. Start server with `start-server.bat`
2. Open: `http://localhost:8080/api/products`
3. Should see products JSON
4. Open on mobile: `http://192.168.254.179:8080/pos`
5. Tap menu items - should add to cart!

## 📁 Clean Project Structure

```
FjoysPOS/
├── app/
│   ├── Controllers/
│   │   ├── Api/              # API endpoints
│   │   ├── Dashboard.php     # Admin dashboard
│   │   └── Pos.php          # POS controller
│   ├── Models/              # Data models
│   ├── Views/
│   │   ├── dashboard.php    # Admin views
│   │   ├── products.php
│   │   └── reports.php
│   └── Database/
│       ├── Migrations/      # Database schema
│       └── Seeds/           # Sample data
├── public/
│   ├── index.php           # Entry point
│   ├── pos-mobile.html     # POS app (temporary)
│   └── router.php          # PHP server router
├── start-server.bat        # Easy startup
└── .env                    # Configuration
```

## 🗑️ Files to Keep

**Keep these:**
- `public/pos-mobile.html` - Working POS app
- `public/diagnostic.html` - For testing
- `public/router.php` - For PHP built-in server
- `start-server.bat` - Easy startup

**Can delete (test files):**
- `public/pos.html` - Old version
- `public/pos-app.js` - Old version  
- `test-api.html` - Move to root if needed

## 🚀 Final Steps

1. **Start server properly:**
   ```bash
   start-server.bat
   ```

2. **Verify on computer:**
   ```
   http://localhost:8080/pos
   ```

3. **Access on mobile:**
   ```
   http://192.168.254.179:8080/pos
   ```

4. **Tap menu items** - Should work now!

## ❓ Still Not Working?

Check these:

1. **Server running?**
   - Should see "CodeIgniter development server started"
   
2. **Database has products?**
   ```bash
   php spark db:seed ProductSeeder
   ```

3. **API working?**
   - Open: `http://localhost:8080/api/products`
   - Should return JSON

4. **Firewall?**
   ```bash
   netsh advfirewall firewall add rule name="PHP Server" dir=in action=allow protocol=TCP localport=8080
   ```

5. **Check console on mobile:**
   - Connect via USB debugging
   - Open `chrome://inspect`
   - Look for errors

The key is using `php spark serve` instead of `php -S` directly!
