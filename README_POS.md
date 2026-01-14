# Food Stand POS System

An offline-first Progressive Web App (PWA) Point of Sale system for food stands.

## Features

- **Offline-First**: Works without internet connection
- **Touch-Friendly**: Optimized for mobile devices
- **Auto-Sync**: Automatically syncs transactions when online
- **Cash Payments**: Simple cash payment workflow
- **Real-time Updates**: Menu updates from server when online

## Setup Instructions

### 1. Database Setup

Configure your database in `.env` file:

```env
database.default.hostname = localhost
database.default.database = food_stand_pos
database.default.username = your_username
database.default.password = your_password
database.default.DBDriver = MySQLi
```

### 2. Run Migrations

```bash
php spark migrate
```

### 3. Seed Sample Data

```bash
php spark db:seed ProductSeeder
```

### 4. Configure API Key

Update the API key in:
- `.env`: `API_KEY=your-secret-api-key-change-this`
- `public/pos-app.js`: Update `API_KEY` constant

### 5. Start Server

```bash
php spark serve
```

### 6. Access POS App

Open on your mobile device:
```
http://your-server-ip:8080/pos.html
```

## Installing as PWA on Android

1. Open `http://your-server-ip:8080/pos.html` in Chrome
2. Tap the menu (⋮) and select "Add to Home screen"
3. The app will appear as a standalone app icon
4. Open it for full-screen experience

## API Endpoints

### Products
- `GET /api/products` - Get all active products
- `GET /api/products/{id}` - Get single product

### Transactions
- `POST /api/transactions/sync` - Sync offline transactions
- `GET /api/transactions/daily-sales?date=YYYY-MM-DD` - Get daily sales
- `GET /api/transactions/report?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD` - Get sales report

All API endpoints require `X-API-Key` header.

## Usage Workflow

1. **Cashier opens POS app** on Android device
2. **Select menu items** by tapping product buttons
3. **Adjust quantities** using +/- buttons
4. **Tap "Pay Cash"** button
5. **Enter cash received** or use quick amount buttons
6. **Complete payment** - transaction saved locally
7. **Auto-sync** when internet available

## Offline Capability

- Menu items cached in IndexedDB
- Transactions saved locally when offline
- Automatic sync every 30 seconds when online
- Visual online/offline indicator

## Future Enhancements

- Multiple branches support
- Digital payment methods
- Inventory tracking
- Kitchen display system
- Sales analytics dashboard
- Receipt printing
- Customer display

## Technical Stack

**Backend:**
- CodeIgniter 4
- MySQL/MariaDB
- RESTful API

**Frontend:**
- Vanilla JavaScript
- IndexedDB for offline storage
- Service Worker for PWA
- Responsive CSS

## Security Notes

- Change default API key in production
- Use HTTPS in production
- Implement proper authentication for admin features
- Regular database backups recommended

## Troubleshooting

**Menu not loading:**
- Check API key matches in both `.env` and `pos-app.js`
- Verify database connection
- Check browser console for errors

**Sync not working:**
- Verify internet connection
- Check API endpoint accessibility
- Review server logs for errors

**PWA not installing:**
- Ensure HTTPS (required for PWA in production)
- Check manifest.json is accessible
- Verify service worker registration
