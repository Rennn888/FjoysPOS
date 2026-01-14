// Configuration
const API_BASE_URL = window.location.origin;
const API_KEY = 'your-secret-api-key-change-this';
const DB_NAME = 'FoodStandPOS';
const DB_VERSION = 1;

// State
let db = null;
let cart = [];
let products = [];
let isOnline = navigator.onLine;

// Initialize
document.addEventListener('DOMContentLoaded', async () => {
    await initDB();
    await loadProducts();
    setupEventListeners();
    updateOnlineStatus();
    startSyncInterval();
    
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch(err => {
            console.log('Service Worker registration failed:', err);
        });
    }
});

// IndexedDB Setup
function initDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);
        
        request.onerror = () => reject(request.error);
        request.onsuccess = () => {
            db = request.result;
            resolve(db);
        };
        
        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            
            if (!db.objectStoreNames.contains('products')) {
                db.createObjectStore('products', { keyPath: 'id' });
            }
            
            if (!db.objectStoreNames.contains('transactions')) {
                const txStore = db.createObjectStore('transactions', { keyPath: 'transaction_id' });
                txStore.createIndex('synced', 'synced', { unique: false });
                txStore.createIndex('transaction_date', 'transaction_date', { unique: false });
            }
        };
    });
}

// Load Products
async function loadProducts() {
    try {
        // Try to fetch from API
        if (isOnline) {
            const response = await fetch(`${API_BASE_URL}/api/products`, {
                headers: { 'X-API-Key': API_KEY }
            });
            
            if (response.ok) {
                const data = await response.json();
                products = data.data;
                await saveProductsToLocal(products);
            }
        }
    } catch (error) {
        console.log('Failed to fetch from API, loading from local');
    }
    
    // Load from local storage
    if (products.length === 0) {
        products = await getProductsFromLocal();
    }
    
    renderMenu();
}

function saveProductsToLocal(products) {
    return new Promise((resolve, reject) => {
        const tx = db.transaction(['products'], 'readwrite');
        const store = tx.objectStore('products');
        
        products.forEach(product => store.put(product));
        
        tx.oncomplete = () => resolve();
        tx.onerror = () => reject(tx.error);
    });
}

function getProductsFromLocal() {
    return new Promise((resolve, reject) => {
        const tx = db.transaction(['products'], 'readonly');
        const store = tx.objectStore('products');
        const request = store.getAll();
        
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

// Render Menu
function renderMenu() {
    const menuSection = document.getElementById('menuSection');
    
    if (products.length === 0) {
        menuSection.innerHTML = '<div class="category-title">No products available</div>';
        return;
    }
    
    // Group by category
    const categories = {};
    products.forEach(product => {
        const cat = product.category || 'Other';
        if (!categories[cat]) categories[cat] = [];
        categories[cat].push(product);
    });
    
    let html = '';
    Object.keys(categories).sort().forEach(category => {
        html += `<div class="category-title">${category}</div>`;
        html += '<div class="menu-grid">';
        categories[category].forEach(product => {
            html += `
                <div class="menu-item" onclick="addToCart(${product.id})">
                    <div class="menu-item-name">${product.name}</div>
                    <div class="menu-item-price">$${parseFloat(product.price).toFixed(2)}</div>
                </div>
            `;
        });
        html += '</div>';
    });
    
    menuSection.innerHTML = html;
}

// Cart Functions
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;
    
    const existingItem = cart.find(item => item.id === productId);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: parseFloat(product.price),
            quantity: 1
        });
    }
    
    renderCart();
}

function updateQuantity(productId, delta) {
    const item = cart.find(item => item.id === productId);
    if (!item) return;
    
    item.quantity += delta;
    if (item.quantity <= 0) {
        cart = cart.filter(item => item.id !== productId);
    }
    
    renderCart();
}

function clearCart() {
    if (confirm('Clear all items from cart?')) {
        cart = [];
        renderCart();
    }
}

function renderCart() {
    const cartItems = document.getElementById('cartItems');
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total');
    const clearBtn = document.getElementById('clearBtn');
    const payBtn = document.getElementById('payBtn');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<div class="empty-cart">Cart is empty</div>';
        subtotalEl.textContent = '$0.00';
        totalEl.textContent = '$0.00';
        clearBtn.disabled = true;
        payBtn.disabled = true;
        return;
    }
    
    let html = '';
    let subtotal = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        
        html += `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">$${item.price.toFixed(2)} × ${item.quantity} = $${itemTotal.toFixed(2)}</div>
                </div>
                <div class="cart-item-controls">
                    <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">−</button>
                    <div class="qty-display">${item.quantity}</div>
                    <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                </div>
            </div>
        `;
    });
    
    cartItems.innerHTML = html;
    subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
    totalEl.textContent = `$${subtotal.toFixed(2)}`;
    clearBtn.disabled = false;
    payBtn.disabled = false;
}

// Payment
function openPaymentModal() {
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('modalTotal').textContent = `$${total.toFixed(2)}`;
    document.getElementById('cashReceived').value = '';
    document.getElementById('changeAmount').textContent = '$0.00';
    document.getElementById('completePayBtn').disabled = true;
    document.getElementById('paymentModal').classList.add('active');
    document.getElementById('cashReceived').focus();
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.remove('active');
}

function calculateChange() {
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;
    const change = cashReceived - total;
    
    document.getElementById('changeAmount').textContent = `$${change.toFixed(2)}`;
    document.getElementById('completePayBtn').disabled = change < 0;
    
    return change;
}

async function completePayment() {
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;
    const change = calculateChange();
    
    if (change < 0) {
        alert('Insufficient cash received');
        return;
    }
    
    const transaction = {
        transaction_id: `TXN-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`,
        device_id: getDeviceId(),
        items: cart.map(item => ({
            product_id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.quantity
        })),
        subtotal: total,
        total: total,
        payment_method: 'cash',
        cash_received: cashReceived,
        change_given: change,
        transaction_date: new Date().toISOString(),
        synced: false
    };
    
    await saveTransaction(transaction);
    
    alert(`Payment Complete!\n\nTotal: $${total.toFixed(2)}\nCash: $${cashReceived.toFixed(2)}\nChange: $${change.toFixed(2)}`);
    
    cart = [];
    renderCart();
    closePaymentModal();
    
    // Try to sync immediately
    if (isOnline) {
        syncTransactions();
    }
}

function saveTransaction(transaction) {
    return new Promise((resolve, reject) => {
        const tx = db.transaction(['transactions'], 'readwrite');
        const store = tx.objectStore('transactions');
        const request = store.add(transaction);
        
        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);
    });
}

// Sync
async function syncTransactions() {
    if (!isOnline) return;
    
    try {
        const unsyncedTx = await getUnsyncedTransactions();
        if (unsyncedTx.length === 0) return;
        
        const response = await fetch(`${API_BASE_URL}/api/transactions/sync`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-API-Key': API_KEY
            },
            body: JSON.stringify({ transactions: unsyncedTx })
        });
        
        if (response.ok) {
            const result = await response.json();
            if (result.success) {
                await markTransactionsAsSynced(result.synced_ids);
                console.log(`Synced ${result.synced} transactions`);
            }
        }
    } catch (error) {
        console.log('Sync failed:', error);
    }
}

function getUnsyncedTransactions() {
    return new Promise((resolve, reject) => {
        const tx = db.transaction(['transactions'], 'readonly');
        const store = tx.objectStore('transactions');
        const index = store.index('synced');
        const request = index.getAll(false);
        
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

function markTransactionsAsSynced(transactionIds) {
    return new Promise((resolve, reject) => {
        const tx = db.transaction(['transactions'], 'readwrite');
        const store = tx.objectStore('transactions');
        
        transactionIds.forEach(id => {
            const request = store.get(id);
            request.onsuccess = () => {
                const transaction = request.result;
                if (transaction) {
                    transaction.synced = true;
                    store.put(transaction);
                }
            };
        });
        
        tx.oncomplete = () => resolve();
        tx.onerror = () => reject(tx.error);
    });
}

function startSyncInterval() {
    setInterval(() => {
        if (isOnline) {
            syncTransactions();
        }
    }, 30000); // Sync every 30 seconds
}

// Utilities
function getDeviceId() {
    let deviceId = localStorage.getItem('device_id');
    if (!deviceId) {
        deviceId = `DEVICE-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
        localStorage.setItem('device_id', deviceId);
    }
    return deviceId;
}

function updateOnlineStatus() {
    isOnline = navigator.onLine;
    const statusDot = document.getElementById('statusDot');
    const statusText = document.getElementById('statusText');
    
    if (isOnline) {
        statusDot.classList.remove('offline');
        statusText.textContent = 'Online';
        syncTransactions();
    } else {
        statusDot.classList.add('offline');
        statusText.textContent = 'Offline';
    }
}

// Event Listeners
function setupEventListeners() {
    document.getElementById('clearBtn').addEventListener('click', clearCart);
    document.getElementById('payBtn').addEventListener('click', openPaymentModal);
    document.getElementById('cancelPayBtn').addEventListener('click', closePaymentModal);
    document.getElementById('completePayBtn').addEventListener('click', completePayment);
    document.getElementById('cashReceived').addEventListener('input', calculateChange);
    document.getElementById('exactBtn').addEventListener('click', () => {
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('cashReceived').value = total.toFixed(2);
        calculateChange();
    });
    
    document.querySelectorAll('.quick-amount-btn[data-amount]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('cashReceived').value = btn.dataset.amount;
            calculateChange();
        });
    });
    
    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
}
