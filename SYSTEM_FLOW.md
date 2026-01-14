# System Flow Diagrams

Visual guide to understanding how the Food Stand POS works.

## 🔄 Overall System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     FOOD STAND POS SYSTEM                    │
└─────────────────────────────────────────────────────────────┘

┌──────────────────────┐              ┌──────────────────────┐
│   ANDROID DEVICE     │              │   SERVER (CI4)       │
│   (POS Frontend)     │◄────────────►│   (Backend API)      │
│                      │   Internet   │                      │
│  ┌────────────────┐  │   (Optional) │  ┌────────────────┐  │
│  │   pos.html     │  │              │  │ API Controllers│  │
│  │   pos-app.js   │  │              │  │   - Products   │  │
│  │                │  │              │  │   - Transactions│ │
│  └────────────────┘  │              │  └────────────────┘  │
│                      │              │                      │
│  ┌────────────────┐  │              │  ┌────────────────┐  │
│  │   IndexedDB    │  │              │  │   MySQL DB     │  │
│  │  - Products    │  │              │  │  - products    │  │
│  │  - Transactions│  │              │  │  - transactions│  │
│  └────────────────┘  │              │  └────────────────┘  │
│                      │              │                      │
│  ┌────────────────┐  │              │  ┌────────────────┐  │
│  │ Service Worker │  │              │  │   Dashboard    │  │
│  │ (Offline Mode) │  │              │  │   (Admin UI)   │  │
│  └────────────────┘  │              │  └────────────────┘  │
└──────────────────────┘              └──────────────────────┘
```

## 📱 POS Application Flow

```
┌─────────────────────────────────────────────────────────────┐
│                    CASHIER WORKFLOW                          │
└─────────────────────────────────────────────────────────────┘

    1. Open POS App
           │
           ▼
    2. View Menu Items
       (Loaded from IndexedDB)
           │
           ▼
    3. Tap Items to Add to Cart
       (Stored in memory)
           │
           ▼
    4. Adjust Quantities (+/-)
       (Update cart)
           │
           ▼
    5. Tap "Pay Cash"
       (Open payment modal)
           │
           ▼
    6. Enter Cash Amount
       (Calculate change)
           │
           ▼
    7. Tap "Complete"
           │
           ▼
    8. Save Transaction
       (To IndexedDB)
           │
           ▼
    9. Sync to Server
       (If online)
           │
           ▼
   10. Clear Cart
       (Ready for next order)
```

## 🌐 Online vs Offline Flow

### Online Mode (Green Dot)

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│   Complete   │         │     Save     │         │     Sync     │
│  Transaction │────────►│  to IndexDB  │────────►│  to Server   │
│              │         │              │         │  (Immediate) │
└──────────────┘         └──────────────┘         └──────────────┘
                                                           │
                                                           ▼
                                                   ┌──────────────┐
                                                   │   Mark as    │
                                                   │   Synced     │
                                                   └──────────────┘
```

### Offline Mode (Red Dot)

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│   Complete   │         │     Save     │         │   Mark as    │
│  Transaction │────────►│  to IndexDB  │────────►│  Unsynced    │
│              │         │              │         │              │
└──────────────┘         └──────────────┘         └──────────────┘
                                                           │
                                                           │
                         ┌──────────────┐                 │
                         │   Internet   │◄────────────────┘
                         │   Returns    │
                         └──────────────┘
                                 │
                                 ▼
                         ┌──────────────┐
                         │   Auto-Sync  │
                         │  (Every 30s) │
                         └──────────────┘
                                 │
                                 ▼
                         ┌──────────────┐
                         │   Mark as    │
                         │   Synced     │
                         └──────────────┘
```

## 🔄 Data Synchronization Flow

```
┌─────────────────────────────────────────────────────────────┐
│                   SYNC PROCESS                               │
└─────────────────────────────────────────────────────────────┘

    Every 30 seconds (if online):
    
    1. Query IndexedDB
       ↓
    2. Find Unsynced Transactions
       ↓
    3. Prepare Batch Request
       ↓
    4. POST to /api/transactions/sync
       ↓
    5. Server Validates
       ↓
    6. Check for Duplicates
       ↓
    7. Insert New Transactions
       ↓
    8. Return Success IDs
       ↓
    9. Mark as Synced in IndexedDB
       ↓
   10. Ready for Next Sync
```

## 🗄️ Database Interaction

```
┌─────────────────────────────────────────────────────────────┐
│                   API REQUEST FLOW                           │
└─────────────────────────────────────────────────────────────┘

Client Request
     │
     ▼
┌─────────────┐
│  API Filter │  ← Check X-API-Key header
└─────────────┘
     │
     ▼ (Authorized)
┌─────────────┐
│ Controller  │  ← ProductController / TransactionController
└─────────────┘
     │
     ▼
┌─────────────┐
│   Model     │  ← ProductModel / TransactionModel
└─────────────┘
     │
     ▼
┌─────────────┐
│  Database   │  ← MySQL Query
└─────────────┘
     │
     ▼
┌─────────────┐
│   Result    │  ← JSON Response
└─────────────┘
     │
     ▼
Client Response
```

## 💳 Payment Processing Flow

```
┌─────────────────────────────────────────────────────────────┐
│                   PAYMENT WORKFLOW                           │
└─────────────────────────────────────────────────────────────┘

    Cart with Items
           │
           ▼
    Calculate Total
           │
           ▼
    Open Payment Modal
           │
           ▼
    ┌──────────────────────────┐
    │  Enter Cash Amount       │
    │  - Type manually         │
    │  - Quick buttons ($5-100)│
    │  - Exact amount button   │
    └──────────────────────────┘
           │
           ▼
    Calculate Change
    (Cash - Total)
           │
           ▼
    ┌──────────────────────────┐
    │  Validation              │
    │  - Cash >= Total?        │
    │  - Valid number?         │
    └──────────────────────────┘
           │
           ▼ (Valid)
    Create Transaction Object
    {
      transaction_id,
      items,
      total,
      cash_received,
      change_given,
      timestamp
    }
           │
           ▼
    Save to IndexedDB
           │
           ▼
    Sync to Server (if online)
           │
           ▼
    Show Success
           │
           ▼
    Clear Cart
```

## 🔐 Security Flow

```
┌─────────────────────────────────────────────────────────────┐
│                   API AUTHENTICATION                         │
└─────────────────────────────────────────────────────────────┘

    API Request
         │
         ▼
    ┌─────────────┐
    │ Check Header│
    │ X-API-Key   │
    └─────────────┘
         │
         ├─────────────┐
         │             │
    (Missing)      (Present)
         │             │
         ▼             ▼
    ┌─────────┐   ┌─────────┐
    │ 401     │   │ Compare │
    │ Reject  │   │ with    │
    └─────────┘   │ .env    │
                  └─────────┘
                       │
                       ├─────────────┐
                       │             │
                  (Match)       (No Match)
                       │             │
                       ▼             ▼
                  ┌─────────┐   ┌─────────┐
                  │ Allow   │   │ 401     │
                  │ Request │   │ Reject  │
                  └─────────┘   └─────────┘
```

## 📊 Reporting Flow

```
┌─────────────────────────────────────────────────────────────┐
│                   DASHBOARD REPORTS                          │
└─────────────────────────────────────────────────────────────┘

    Admin Opens Dashboard
           │
           ▼
    ┌──────────────────────────┐
    │  Today's Sales Summary   │
    │  - Total sales           │
    │  - Transaction count     │
    │  - Product count         │
    └──────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐
    │  Recent Transactions     │
    │  - Last 10 transactions  │
    │  - Sync status           │
    └──────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐
    │  Generate Report         │
    │  - Select date range     │
    │  - View details          │
    │  - Export data           │
    └──────────────────────────┘
```

## 🔄 PWA Installation Flow

```
┌─────────────────────────────────────────────────────────────┐
│                   PWA INSTALLATION                           │
└─────────────────────────────────────────────────────────────┘

    Open pos.html in Chrome
           │
           ▼
    Service Worker Registers
           │
           ▼
    Manifest.json Loaded
           │
           ▼
    User: Menu → "Add to Home screen"
           │
           ▼
    Icon Added to Home Screen
           │
           ▼
    User Taps Icon
           │
           ▼
    App Opens in Standalone Mode
    (Full screen, no browser UI)
           │
           ▼
    Service Worker Enables Offline
           │
           ▼
    IndexedDB Stores Data
           │
           ▼
    App Works Offline!
```

## 🎯 Complete Transaction Lifecycle

```
┌─────────────────────────────────────────────────────────────┐
│              TRANSACTION LIFECYCLE                           │
└─────────────────────────────────────────────────────────────┘

1. CREATION
   └─► Cashier adds items to cart
   
2. CALCULATION
   └─► System calculates total
   
3. PAYMENT
   └─► Cash received, change calculated
   
4. LOCAL STORAGE
   └─► Saved to IndexedDB with unique ID
   
5. SYNC ATTEMPT
   ├─► Online: Immediate sync to server
   └─► Offline: Marked for later sync
   
6. SERVER STORAGE
   └─► Stored in MySQL database
   
7. CONFIRMATION
   └─► Marked as synced in IndexedDB
   
8. REPORTING
   └─► Available in dashboard reports
   
9. BACKUP
   └─► Included in database backups
   
10. ARCHIVE
    └─► Retained for historical analysis
```

## 🚀 Startup Sequence

```
┌─────────────────────────────────────────────────────────────┐
│                   APP STARTUP                                │
└─────────────────────────────────────────────────────────────┘

    User Opens POS App
           │
           ▼
    Initialize IndexedDB
           │
           ▼
    Register Service Worker
           │
           ▼
    Check Online Status
           │
           ├──────────────┐
           │              │
      (Online)       (Offline)
           │              │
           ▼              ▼
    Fetch Products   Load from
    from API         IndexedDB
           │              │
           └──────┬───────┘
                  │
                  ▼
           Render Menu
                  │
                  ▼
           Setup Event Listeners
                  │
                  ▼
           Start Sync Timer
                  │
                  ▼
           Ready for Orders!
```

---

## 📝 Key Takeaways

1. **Offline First**: App works without internet
2. **Auto-Sync**: Transparent background synchronization
3. **Local Storage**: IndexedDB for reliable offline storage
4. **PWA**: Installable as standalone app
5. **Simple Flow**: Easy for cashiers to use
6. **Reliable**: No data loss, even offline
7. **Scalable**: Ready for growth

## 🎓 Understanding the Flow

- **Green paths**: Normal online operation
- **Red paths**: Offline operation
- **Blue paths**: Sync/recovery operations
- **Dashed lines**: Optional/conditional flows

All flows are designed to be:
- ✅ Fast
- ✅ Reliable
- ✅ User-friendly
- ✅ Fault-tolerant
