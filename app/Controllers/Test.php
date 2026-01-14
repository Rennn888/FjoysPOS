<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Test extends BaseController
{
    public function checkDatabase()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll();
        
        echo "<h1>Database Check</h1>";
        echo "<p>Total products in database: " . count($products) . "</p>";
        
        if (count($products) === 0) {
            echo "<p style='color: red;'>❌ NO PRODUCTS FOUND!</p>";
            echo "<p>Run this command: <code>php spark db:seed ProductSeeder</code></p>";
        } else {
            echo "<p style='color: green;'>✅ Products found:</p>";
            echo "<ul>";
            foreach ($products as $product) {
                echo "<li>{$product['name']} - \${$product['price']} (Active: {$product['is_active']})</li>";
            }
            echo "</ul>";
        }
        
        echo "<hr>";
        echo "<h2>API Test</h2>";
        echo "<p>API endpoint: <a href='/api/products'>/api/products</a></p>";
        echo "<p>Click the link above to test the API</p>";
    }
    
    public function testFrontend()
    {
        echo '<!DOCTYPE html>
<html>
<head>
    <title>Frontend Test</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .product { background: #f0f0f0; padding: 15px; margin: 10px; border-radius: 5px; cursor: pointer; }
        .product:hover { background: #e0e0e0; }
        #cart { background: #fff; padding: 15px; margin-top: 20px; border: 2px solid #333; }
    </style>
</head>
<body>
    <h1>Frontend Test</h1>
    <div id="products">Loading...</div>
    <div id="cart">
        <h2>Cart</h2>
        <div id="cartItems">Empty</div>
        <div id="total">Total: $0.00</div>
    </div>
    
    <script>
        let cart = [];
        let products = [];
        
        async function loadProducts() {
            console.log("Loading products...");
            try {
                const response = await fetch("/api/products", {
                    headers: { "X-API-Key": "Fjoy3211" }
                });
                
                console.log("Response status:", response.status);
                
                const data = await response.json();
                console.log("Data received:", data);
                
                products = data.data || [];
                console.log("Products array:", products);
                
                renderProducts();
            } catch (error) {
                console.error("Error:", error);
                document.getElementById("products").innerHTML = "<p style=\"color:red;\">Error: " + error.message + "</p>";
            }
        }
        
        function renderProducts() {
            const container = document.getElementById("products");
            
            if (products.length === 0) {
                container.innerHTML = "<p style=\"color:red;\">No products found. Run: php spark db:seed ProductSeeder</p>";
                return;
            }
            
            let html = "";
            products.forEach(product => {
                html += `<div class="product" data-product-id="${product.id}">
                    ${product.name} - $${product.price}
                </div>`;
            });
            
            container.innerHTML = html;
            
            // Add event listeners AFTER rendering
            document.querySelectorAll('.product').forEach(element => {
                element.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-product-id'));
                    console.log('Product clicked:', productId);
                    addToCart(productId);
                });
            });
            
            console.log('Event listeners attached to', document.querySelectorAll('.product').length, 'products');
        }
        
        function addToCart(productId) {
            console.log("Adding product:", productId);
            
            const product = products.find(p => p.id === productId);
            if (!product) {
                console.error("Product not found:", productId);
                return;
            }
            
            const existing = cart.find(item => item.id === productId);
            if (existing) {
                existing.quantity++;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    quantity: 1
                });
            }
            
            console.log("Cart:", cart);
            renderCart();
        }
        
        function renderCart() {
            const cartItems = document.getElementById("cartItems");
            const totalEl = document.getElementById("total");
            
            if (cart.length === 0) {
                cartItems.innerHTML = "Empty";
                totalEl.innerHTML = "Total: $0.00";
                return;
            }
            
            let html = "";
            let total = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                html += `<div>${item.name} x${item.quantity} = $${itemTotal.toFixed(2)}</div>`;
            });
            
            cartItems.innerHTML = html;
            totalEl.innerHTML = `Total: $${total.toFixed(2)}`;
        }
        
        loadProducts();
    </script>
</body>
</html>';
    }
}
