<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ config('app.name', 'Laravel') }}</title>
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

        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }

        @media (max-width: 968px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }

        /* Checkout Form */
        .checkout-form {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.5em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* Payment Methods */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .payment-method {
            position: relative;
        }

        .payment-input {
            position: absolute;
            opacity: 0;
        }

        .payment-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .payment-input:checked + .payment-label {
            border-color: #3498db;
            background: #f0f8ff;
        }

        .payment-icon {
            font-size: 2em;
            margin-bottom: 8px;
        }

        .visa-icon { color: #1a1f71; }
        .apple-pay-icon { color: #000; }
        .mada-icon { color: #4CAF50; }

        /* Order Summary */
        .order-summary {
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

        .order-items {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .item-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .item-price {
            color: #27ae60;
            font-weight: 600;
        }

        .summary-totals {
            border-top: 2px solid #ecf0f1;
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .total-label {
            color: #7f8c8d;
        }

        .total-value {
            font-weight: 600;
        }

        .grand-total {
            font-size: 1.3em;
            font-weight: 700;
            color: #27ae60;
            border-top: 2px solid #ecf0f1;
            padding-top: 10px;
            margin-top: 10px;
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
            <a href="{{ route('cart.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Cart
            </a>
            <h1 class="page-title">Checkout</h1>
            <div style="width: 100px;"></div>
        </div>

        <div class="checkout-container">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form id="checkoutForm">
                    @csrf

                    <!-- Personal Information -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-user"></i> Personal Information
                        </h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="customer_name" class="form-control" required 
                                       value="{{ Auth::user()->name }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email *</label>
                                <input type="email" name="customer_email" class="form-control" required
                                       value="{{ Auth::user()->email }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="customer_phone" class="form-control" required
                                       placeholder="+966 5X XXX XXXX">
                            </div>
                            <div class="form-group">
                                <label class="form-label">City *</label>
                                <input type="text" name="customer_city" class="form-control" required
                                       placeholder="Riyadh">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address *</label>
                            <textarea name="customer_address" class="form-control form-textarea" required
                                      placeholder="Enter your full address"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="customer_country" class="form-control" 
                                   value="Saudi Arabia" readonly>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </h2>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <input type="radio" name="payment_method" value="visa" 
                                       id="visa" class="payment-input" checked required>
                                <label for="visa" class="payment-label">
                                    <i class="fab fa-cc-visa payment-icon visa-icon"></i>
                                    <span>Visa</span>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" value="apple_pay" 
                                       id="apple_pay" class="payment-input" required>
                                <label for="apple_pay" class="payment-label">
                                    <i class="fab fa-cc-apple-pay payment-icon apple-pay-icon"></i>
                                    <span>Apple Pay</span>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" value="mada" 
                                       id="mada" class="payment-input" required>
                                <label for="mada" class="payment-label">
                                    <i class="fas fa-credit-card payment-icon mada-icon"></i>
                                    <span>Mada</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-sticky-note"></i> Order Notes (Optional)
                        </h2>
                        <div class="form-group">
                            <textarea name="notes" class="form-control form-textarea"
                                      placeholder="Any special instructions for your order..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="checkout-btn" id="submitBtn">
                        <i class="fas fa-lock"></i> Complete Order - ${{ number_format($total, 2) }}
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h2 class="summary-title">Order Summary</h2>
                
                <div class="order-items">
                    @foreach($cartItems as $item)
                    <div class="order-item">
                        <img src="{{ asset('images/products/' . $item->product->image) }}" 
                             alt="{{ $item->product->name }}" class="item-image"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHZpZXdCb3g9IjAgMCA1MCA1MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIGZpbGw9IiNGM0Y0RjYiLz48cGF0aCBkPSJNMjUuNSAyNS41QzIzLjAxMTcgMjUuNSAyMSAyNy41MTE3IDIxIDMwQzIxIDMyLjQ4ODMgMjMuMDExNyAzNC41IDI1LjUgMzQuNUMyNy45ODgzIDM0LjUgMzAgMzIuNDg4MyAzMCAzMEMzMCAyNy41MTE3IDI3Ljk4ODMgMjUuNSAyNS41IDI1LjVaTTM1IDM1QzM1IDM1IDM1IDMwIDI1IDMwQzE1IDMwIDE1IDM1IDE1IDM1SDM1WiIgZmlsbD0iIzk3QThBQiIvPjwvc3ZnPg=='">
                        <div class="item-details">
                            <div class="item-name">{{ $item->product->name }}</div>
                            <div class="item-price">${{ number_format($item->product->price, 2) }} x {{ $item->quantity }}</div>
                        </div>
                        <div class="item-total">${{ number_format($item->quantity * $item->product->price, 2) }}</div>
                    </div>
                    @endforeach
                </div>

                <div class="summary-totals">
                    <div class="total-row">
                        <span class="total-label">Subtotal:</span>
                        <span class="total-value">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Shipping:</span>
                        <span class="total-value">${{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Tax (10%):</span>
                        <span class="total-value">${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="total-row grand-total">
                        <span class="total-label">Total:</span>
                        <span class="total-value">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            
            try {
                // إظهار تحميل
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
                
                const formData = new FormData(this);
                
                const response = await fetch('{{ route("checkout.process") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification('Order placed successfully! Redirecting...', 'success');
                    
                    // الانتقال إلى صفحة التأكيد بعد ثانيتين
                    setTimeout(() => {
                        window.location.href = `/order/confirmation/${data.order_id}`;
                    }, 2000);
                    
                } else {
                    throw new Error(data.error || 'Payment failed');
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message, 'error');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        function showNotification(message, type = 'info') {
            // إزالة أي إشعارات سابقة
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }
            
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

        // تحسين تجربة المستخدم
        document.querySelectorAll('.payment-input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.payment-label').forEach(label => {
                    label.style.borderColor = '#e2e8f0';
                    label.style.background = 'transparent';
                });
                
                const label = this.nextElementSibling;
                label.style.borderColor = '#3498db';
                label.style.background = '#f0f8ff';
            });
        });

        // تفعيل أول طريقة دفع افتراضياً
        document.querySelector('.payment-input').checked = true;
        document.querySelector('.payment-input').dispatchEvent(new Event('change'));
    </script>
</body>
</html>