# Quick Start Guide - Food Stand POS

Get up and running in 5 minutes!

## 1. Install Dependencies

```bash
composer install
```

## 2. Setup Database

Edit `.env` file:
```env
database.default.database = food_stand_pos
database.default.username = root
database.default.password = your_password
```

Create database:
```bash
# MySQL command line
mysql -u root -p
CREATE DATABASE food_stand_pos;
exit;
```

## 3. Run Migrations & Seed Data

```bash
php spark migrate
php spark db:seed ProductSeeder
```

## 4. Start Server

```bash
php spark serve --host=0.0.0.0
```

## 5. Access the System

**Dashboard:** http://localhost:8080/dashboard

**POS App:** http://localhost:8080/pos.html

**API Test:** Open `test-api.html` in browser

## 6. Test on Mobile

1. Find your computer's IP address:
   - Windows: `ipconfig`
   - Mac/Linux: `ifconfig` or `ip addr`

2. On your Android device, open Chrome and go to:
   ```
   http://YOUR_IP:8080/pos.html
   ```

3. Add to home screen (Chrome menu → Add to Home screen)

## Default Configuration

- **API Key:** `your-secret-api-key-change-this`
- **Database:** `food_stand_pos`
- **Port:** `8080`

## Sample Products Included

- Burger - $5.99
- Hot Dog - $3.99
- Fries - $2.99
- Soda - $1.99
- Water - $1.00
- Taco - $4.50

## Testing the POS

1. Open POS app
2. Tap menu items to add to cart
3. Adjust quantities with +/- buttons
4. Tap "Pay Cash"
5. Enter cash amount or use quick buttons
6. Complete payment

## Verify Everything Works

1. Make a test sale in POS
2. Check Dashboard to see the transaction
3. View Reports to see sales data
4. Test offline: Turn on airplane mode, make sale, turn off airplane mode

## Need Help?

- See `SETUP_GUIDE.md` for detailed instructions
- See `README_POS.md` for full documentation
- Check `writable/logs/` for error logs
- Open `test-api.html` to test API endpoints

## Production Checklist

Before going live:

- [ ] Change API key in `.env` and `pos-app.js`
- [ ] Use HTTPS (required for PWA)
- [ ] Set `CI_ENVIRONMENT = production` in `.env`
- [ ] Setup database backups
- [ ] Test offline functionality thoroughly
- [ ] Configure proper web server (Apache/Nginx)

That's it! You're ready to start selling! 🎉
