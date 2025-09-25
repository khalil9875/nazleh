<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            color: white;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            background: rgba(255,255,255,0.2);
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .page-title {
            font-size: 2.5em;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }

        @media (max-width: 968px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
        }

        /* Cart Items Section */
        .cart-items {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .cart-title {
            font-size: 1.8em;
            font-weight: 600;
            color: #2c3e50;
        }

        .items-count {
            color: #7f8c8d;
            font-size: 1.1em;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto auto;
            gap: 20px;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #ecf0f1;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .item-image {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 1.3em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .item-company {
            color: #7f8c8d;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .item-price {
            font-size: 1.2em;
            font-weight: 700;
            color: #27ae60;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }

        .item-total {
            font-size: 1.3em;
            font-weight: 700;
            color: #2c3e50;
            min-width: 100px;
            text-align: right;
        }

        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: #c0392b;
            transform: scale(1.05);
        }

        /* Summary Section */
        .cart-summary {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-size: 1.5em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px 0;
        }

        .summary-label {
            color: #7f8c8d;
            font-size: 1.1em;
        }

        .summary-value {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1em;
        }

        .summary-total {
            border-top: 2px solid #ecf0f1;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 1.3em;
            font-weight: 700;
            color: #27ae60;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #27ae60 0%, #219a52 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .checkout-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .checkout-btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
        }

        .continue-shopping {
            text-align: center;
            margin-top: 15px;
        }

        .continue-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
        }

        .continue-link:hover {
            text-decoration: underline;
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: white;
        }

        .empty-cart i {
            font-size: 5em;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .empty-cart h2 {
            font-size: 2em;
            margin-bottom: 15px;
        }

        .empty-cart p {
            font-size: 1.2em;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .shop-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .shop-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        /* Notifications */
        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1001;
            animation: slideDown 0.3s ease;
            color: white;
            font-weight: 600;
        }

        .notification-success {
            background: #27ae60;
        }

        .notification-error {
            background: #e74c3c;
        }

        @keyframes slideDown {
            from { transform: translateX(-50%) translateY(-100px); opacity: 0; }
            to { transform: translateX(-50%) translateY(0); opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateX(-50%) translateY(0); opacity: 1; }
            to { transform: translateX(-50%) translateY(-100px); opacity: 0; }
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <a href="{{ url('/') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Shopping
            </a>
            <h1 class="page-title">Shopping Cart</h1>
            <div style="width: 100px;"></div> <!-- spacer for alignment -->
        </div>

        @if($cartItems->count() > 0)
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    <div class="cart-header">
                        <h2 class="cart-title">Your Items</h2>
                        <span class="items-count">{{ $cartItems->count() }} item(s)</span>
                    </div>

                    <div id="cartItemsContainer">
                        @foreach($cartItems as $item)
                            <div class="cart-item" id="cartItem-{{ $item->id }}">
                                <img src="{{ asset('images/products/' . $item->product->image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="item-image"
                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIGZpbGw9IiNGM0Y0RjYiLz48cGF0aCBkPSJNNTAuNSAzMC41QzQ0LjcwMTggMzAuNSA0MCAzNS4yMDE4IDQwIDQxQzQwIDQ2Ljc5ODIgNDQuNzAxOCA1MS41IDUwLjUgNTEuNUM1Ni4yOTgyIDUxLjUgNjEgNDYuNzk4MiA2MSA0MUM2MSAzNS4yMDE4IDU2LjI5ODIgMzAuNSA1MC41IDMwLjVaTTY1IDY1QzY1IDY1IDY1IDUwIDUwIDUwQzM1IDUwIDM1IDY1IDM1IDY1SDY1WiIgZmlsbD0iIzk3QThBQiIvPjwvc3ZnPg=='">

                                <div class="item-details">
                                    <h3 class="item-name">{{ $item->product->name }}</h3>
                                    <p class="item-company">{{ $item->product->company->name }}</p>
                                    <p class="item-price">${{ number_format($item->product->price, 2) }} each</p>
                                </div>

                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" 
                                           class="quantity-input" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="{{ $item->product->quantity }}"
                                           onchange="updateQuantity({{ $item->id }}, 0, this.value)">
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <div class="item-total">
                                    ${{ number_format($item->quantity * $item->product->price, 2) }}
                                </div>

                                <button class="remove-btn" onclick="removeItem({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="cart-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="subtotal">${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Shipping</span>
                        <span class="summary-value">$10.00</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Tax</span>
                        <span class="summary-value">${{ number_format($total * 0.1, 2) }}</span>
                    </div>
                    
                    <div class="summary-row summary-total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="grandTotal">${{ number_format($total + 10 + ($total * 0.1), 2) }}</span>
                    </div>

                    <button class="checkout-btn" >
                        <a href="/checkout">

                          <i class="fas fa-lock"></i> Proceed to Checkout
                        </a>
                      
                    </button>

                    <div class="continue-shopping">
                        <a href="{{ url('/') }}" class="continue-link">
                            <i class="fas fa-shopping-bag"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h2>Your cart is empty</h2>
                <p>Start shopping to add items to your cart</p>
                <a href="{{ url('/') }}" class="shop-btn">
                    <i class="fas fa-store"></i> Start Shopping
                </a>
            </div>
        @endif
    </div>

    <script>
        // دالة تحديث الكمية
        async function updateQuantity(itemId, change, customValue = null) {
            const itemElement = document.getElementById(`cartItem-${itemId}`);
            const quantityInput = itemElement.querySelector('.quantity-input');
            const currentQuantity = parseInt(quantityInput.value);
            const maxQuantity = parseInt(quantityInput.max);
            
            let newQuantity;
            if (customValue !== null) {
                newQuantity = parseInt(customValue);
            } else {
                newQuantity = currentQuantity + change;
            }
            
            // التحقق من الحدود
            if (newQuantity < 1) newQuantity = 1;
            if (newQuantity > maxQuantity) {
                showNotification(`Maximum available quantity is ${maxQuantity}`, 'error');
                newQuantity = maxQuantity;
            }
            
            if (newQuantity === currentQuantity) return;
            
            try {
                itemElement.classList.add('loading');
                
                const response = await fetch(`/cart/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        quantity: newQuantity,
                        _method: 'PUT'
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    quantityInput.value = newQuantity;
                    updateItemTotal(itemId, newQuantity);
                    updateCartSummary();
                    showNotification('Cart updated successfully', 'success');
                } else {
                    throw new Error(data.message);
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to update quantity', 'error');
                quantityInput.value = currentQuantity;
            } finally {
                itemElement.classList.remove('loading');
            }
        }
        
        // دالة تحديث المجموع للعنصر
        function updateItemTotal(itemId, quantity) {
            const itemElement = document.getElementById(`cartItem-${itemId}`);
            const price = parseFloat(itemElement.querySelector('.item-price').textContent.replace('$', ''));
            const totalElement = itemElement.querySelector('.item-total');
            totalElement.textContent = `$${(price * quantity).toFixed(2)}`;
        }
        
        // دالة حذف العنصر
        async function removeItem(itemId) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return;
            }
            
            try {
                const itemElement = document.getElementById(`cartItem-${itemId}`);
                itemElement.classList.add('loading');
                
                const response = await fetch(`/cart/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    itemElement.style.animation = 'slideUp 0.3s ease';
                    setTimeout(() => {
                        itemElement.remove();
                        updateCartSummary();
                        checkEmptyCart();
                    }, 300);
                    
                    showNotification('Item removed from cart', 'success');
                    updateCartCounter();
                } else {
                    throw new Error(data.message);
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to remove item', 'error');
            }
        }
        
        // دالة تحديث ملخص السلة
        function updateCartSummary() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const price = parseFloat(item.querySelector('.item-price').textContent.replace('$', ''));
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                subtotal += price * quantity;
            });
            
            const tax = subtotal * 0.1;
            const shipping = 10.00;
            const grandTotal = subtotal + tax + shipping;
            
            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('grandTotal').textContent = `$${grandTotal.toFixed(2)}`;
        }
        
        // دالة التحقق من السلة الفارغة
        function checkEmptyCart() {
            const cartItems = document.querySelectorAll('.cart-item');
            if (cartItems.length === 0) {
                setTimeout(() => {
                    location.reload(); // إعادة تحميل الصفحة لعرض حالة السلة الفارغة
                }, 500);
            }
        }
        
        // دالة تحديث عداد السلة
        async function updateCartCounter() {
            try {
                const response = await fetch('/cart/count');
                const data = await response.json();
                
                // إذا كان هناك عداد في الصفحة الرئيسية، قم بتحديثه
                if (window.parent && window.parent.updateCartCount) {
                    window.parent.updateCartCount(data.cart_count);
                }
            } catch (error) {
                console.error('Error updating cart counter:', error);
            }
        }
        
        // دالة الإشعارات
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
                ${message}
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // دالة الانتقال للدفع
        function proceedToCheckout() {
            const checkoutBtn = document.querySelector('.checkout-btn');
            checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            checkoutBtn.disabled = true;
            
            // محاكاة عملية الدفع (يمكن استبدالها بالانتقال لصفحة الدفع الحقيقية)
            setTimeout(() => {
                showNotification('Checkout functionality will be implemented soon!', 'success');
                checkoutBtn.innerHTML = '<i class="fas fa-lock"></i> Proceed to Checkout';
                checkoutBtn.disabled = false;
            }, 2000);
        }
        
        // تحميل أولي
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Cart page loaded successfully');
        });
    </script>
</body>
</html>