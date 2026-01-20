# Fjoy's Point of Sale (POS) System

## 📖 Overview

**Fjoy's POS** is a modern, mobile-first Point of Sale system specifically designed for food stands and small quick-service restaurants. Built with **CodeIgniter 4**, it offers a streamlined interface for taking orders, managing customized menu items (like flavored wings and fries), and tracking daily sales.

The system is designed to be **offline-first**, ensuring that operations can continue smoothly even without an internet connection, with data syncing to the server when connectivity is restored.

---

## 🏗️ System Components

The application follows the Model-View-Controller (MVC) architectural pattern:

### 1. Frontend (POS Interface)
- **Technology**: HTML5, Vanilla JavaScript, Custom CSS.
- **Location**: `app/Views/pos/index.php`
- **Description**: A responsive, touch-friendly single-page application (SPA) that runs in the browser. It handles the entire ordering flow, from menu browsing to payment processing.
- **Key Files**: 
  - `index.php`: Contains the UI structure, styling, and client-side logic.
  - State is managed via `localStorage` (Cart, Active Orders, Order Counter).

### 2. Backend (API & Controllers)
- **Technology**: PHP 8.1+ (CodeIgniter 4 Framework).
- **Controllers**:
  - `Pos.php`: Serves the main POS interface.
  - `Api/ProductController.php`: Handles product data retrieval.
  - `Api/TransactionController.php`: Manages transaction syncing and sales reporting.
  - `Dashboard.php`: Admin interface for viewing reports and managing products.

### 3. Database
- **Technology**: MySQL.
- **Structure**:
  - **Products Table**: Stores menu items, prices, and categories.
  - **Transactions Table**: Records completed sales, including detailed item breakdowns, payment methods, and timestamps.

---

## ✨ Key Features

### 📱 Mobile-First Design
- **Responsive Layout**: optimized for tablets and mobile phones.
- **Touch Controls**: Large buttons and gesture-friendly interfaces for fast-paced environments.
- **Visual Feedback**: Micro-animations and clear status indicators.

### 🍗 Specialized Menu Management
- **Flavor Selection**: sophisticated support for items requiring sub-selections, such as:
  - **Wings**: Choose from 11+ flavors (e.g., Salted Egg, Garlic Parmesan, Hot Chili). Supports multi-flavor selection for large platters (Twin/Triple/Fiesta).
  - **Fries**: Selection for Cheese, Sour Cream, or Barbecue.
- **Categorization**: Menu items are automatically grouped (Rice Meals, Ala Carte, Drinks, etc.).

### 🛒 Dynamic Cart & Ordering
- **Real-time Calculation**: Instant subtotal and total updates.
- **Quick Adjustments**: Easy quantity controls (+/-) and line-item removal.
- **Order Tracking**: "Active Orders" panel to track orders currently being prepared in the kitchen.

### 💰 Payment Processing
- **Cash Management**: Built-in calculator for change.
- **Quick Denominations**: One-tap buttons for common blls (₱50, ₱100, ₱500, ₱1000).
- **Transaction History**: Every sale is logged with a unique transaction ID.

### 🔌 Offline Capabilities
- **Resilience**: The POS continues to function if the server connection drops.
- **Local Storage**: Active orders and counter state are persisted in the browser.
- **Syncing**: Transactions are stored locally if offline and synced to the central database once connection is re-established.

### 📊 Dashboard & Analytics
- **Sales Reports**: View daily transaction summaries.
- **Product Performance**: Track best-selling items.
- **Secure Access**: Protected by API keys and environment configurations.

---

## ⚙️ Configuration

### Environment Variables (`.env`)
The system is configured via the `.env` file in the root directory:
- **`CI_ENVIRONMENT`**: Set to `production` for live use.
- **`app.baseURL`**: The URL where the application is hosted.
- **`API_KEY`**: A secure key required for all API requests to prevent unauthorized access.
- **Database Credentials**: Hostname, username, password, and database name.

### Branding
- **Theme Color**: The system uses a primary "Fjoy Red" (#dc2626) theme.
- **Customization**: Styles and flavor options are located directly in `app/Views/pos/index.php` for easy branding adjustments.

---

## 🚀 Getting Started

1. **Start the Server**:
   run the `start-server.bat` script on your Windows host machine.

2. **Access the POS**:
   - **Local**: `http://localhost:8080/pos`
   - **Network**: `http://<YOUR_IP>:8080/pos` (for mobile devices on the same WiFi)

3. **Reset Counter**:
   - Use the 🔄 button in the header or prompt via the browser console to reset order numbers at the start of a business day.