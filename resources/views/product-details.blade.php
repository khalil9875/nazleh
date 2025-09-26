<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - {{ $company->name }}</title>
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

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 25px;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .product-details-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .product-images {
            flex: 1;
            min-width: 300px;
            padding: 20px;
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            overflow-x: auto;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .thumbnail.active, .thumbnail:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        .product-info {
            flex: 1;
            min-width: 300px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-name {
            font-size: 2em;
            font-weight: 700;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .product-price {
            font-size: 1.8em;
            font-weight: 700;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .product-description {
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .options-section {
            margin-bottom: 25px;
        }

        .option-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .options-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .option-btn {
            padding: 8px 15px;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .option-btn.selected {
            border-color: #3498db;
            background: #3498db;
            color: white;
        }

        .option-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #ecf0f1;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            border-color: #3498db;
        }

        .quantity-value {
            font-size: 1.2em;
            font-weight: 600;
            min-width: 30px;
            text-align: center;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        .add-to-cart-btn, .buy-now-btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .add-to-cart-btn {
            background: #27ae60;
            color: white;
        }

        .add-to-cart-btn:hover:not(:disabled) {
            background: #219653;
            transform: translateY(-2px);
        }

        .add-to-cart-btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }

        .buy-now-btn {
            background: #e67e22;
            color: white;
        }

        .buy-now-btn:hover {
            background: #d35400;
            transform: translateY(-2px);
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
            color: #7f8c8d;
            font-size: 0.9em;
        }

        @media (max-width: 768px) {
            .product-details-container {
                flex-direction: column;
            }
            
            .product-images, .product-info {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('companies.products', $company) }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Products
        </a>

        <!-- Product Details -->
        <div class="product-details-container">
            <!-- Product Images -->
            <div class="product-images">
                <img id="mainImage" src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="main-image">
                
                @if($product->additional_images && count(json_decode($product->additional_images)) > 0)
                <div class="thumbnail-container">
                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="thumbnail active" onclick="changeImage(this.src)">
                    
                    @foreach(json_decode($product->additional_images) as $image)
                    <img src="{{ asset('images/products/additional/' . $image) }}" alt="{{ $product->name }}" class="thumbnail" onclick="changeImage(this.src)">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h1 class="product-name">{{ $product->name }}</h1>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                
                @if($product->description)
                <p class="product-description">{{ $product->description }}</p>
                @endif

                <!-- Size Selection -->
                @if($product->sizes && count(json_decode($product->sizes)) > 0)
                <div class="options-section">
                    <div class="option-title">Size</div>
                    <div class="options-container" id="sizeOptions">
                        @foreach(json_decode($product->sizes) as $size)
                        <div class="option-btn size-option" data-size="{{ $size }}">{{ $size }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Color Selection -->
                @if($product->colors && count(json_decode($product->colors)) > 0)
                <div class="options-section">
                    <div class="option-title">Color</div>
                    <div class="options-container" id="colorOptions">
                        @foreach(json_decode($product->colors) as $color)
                        <div class="option-btn color-option" data-color="{{ $color }}">{{ $color }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity Selector -->
                <div class="quantity-selector">
                    <div class="option-title">Quantity</div>
                    <div class="quantity-controls">
                        <div class="quantity-btn" id="decreaseQty"><i class="fas fa-minus"></i></div>
                        <span class="quantity-value" id="quantityValue">1</span>
                        <div class="quantity-btn" id="increaseQty"><i class="fas fa-plus"></i></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button id="addToCartBtn" 
                            class="add-to-cart-btn" 
                            {{ !$product->is_available ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart"></i> 
                        {{ $product->is_available ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                    <button class="buy-now-btn">
                        <i class="fas fa-bolt"></i> Buy Now
                    </button>
                </div>

                <!-- Product Meta -->
                <div class="product-meta">
                    <span><i class="fas fa-cubes"></i> {{ $product->quantity }} in stock</span>
                    <span><i class="fas fa-tag"></i> {{ $company->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // تغيير الصورة الرئيسية
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
            
            // تحديث حالة الثمبنييل النشط
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // اختيار المقاس
        document.querySelectorAll('.size-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.size-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });

        // اختيار اللون
        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.color-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });

        // إدارة الكمية
        let quantity = 1;
        document.getElementById('increaseQty').addEventListener('click', function() {
            if (quantity < {{ $product->quantity }}) {
                quantity++;
                document.getElementById('quantityValue').textContent = quantity;
            }
        });

        document.getElementById('decreaseQty').addEventListener('click', function() {
            if (quantity > 1) {
                quantity--;
                document.getElementById('quantityValue').textContent = quantity;
            }
        });

        // إضافة إلى السلة
        document.getElementById('addToCartBtn').addEventListener('click', function() {
            const selectedSize = document.querySelector('.size-option.selected')?.dataset.size || null;
            const selectedColor = document.querySelector('.color-option.selected')?.dataset.color || null;
            
            addToCartWithOptions({{ $product->id }}, quantity, selectedSize, selectedColor);
        });

        // دالة إضافة إلى السلة مع الخيارات
        async function addToCartWithOptions(productId, quantity, size, color) {
            const button = document.getElementById('addToCartBtn');
            const originalText = button.innerHTML;
            
            try {
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                button.disabled = true;
                
                const response = await fetch('{{ route("cart.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity,
                        size: size,
                        color: color
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // تحديث عداد السلة
                    updateCartCount(data.cart_count);
                    
                    // إظهار رسالة نجاح
                    showNotification('Product added to cart successfully!', 'success');
                    
                    // تأثير زر ناجح
                    button.style.background = '#2ecc71';
                    setTimeout(() => {
                        button.style.background = '#27ae60';
                        button.innerHTML = '<i class="fas fa-check"></i> Added!';
                        setTimeout(() => {
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }, 1000);
                    }, 500);
                    
                } else {
                    throw new Error(data.message);
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to add product to cart', 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }

        // دالة تحديث عداد السلة
        async function updateCartCount(count = null) {
            try {
                if (count === null) {
                    const response = await fetch('{{ route("cart.count") }}');
                    const data = await response.json();
                    count = data.cart_count;
                }
                
                // إذا كان هناك عداد سلة في الصفحة
                const cartCounter = document.getElementById('cartCount');
                if (cartCounter) {
                    cartCounter.textContent = count;
                    
                    // تأثير عند التحديث
                    const counter = document.getElementById('cartCounter');
                    if (counter) {
                        counter.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            counter.style.transform = 'scale(1)';
                        }, 300);
                    }
                }
                
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }

        // دالة إظهار الإشعارات
        function showNotification(message, type = 'info') {
            // إزالة عنصر الإشعار إذا كان موجوداً
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
            
            // إضافة الأنماط
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
                color: white;
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                z-index: 1001;
                animation: slideDown 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            // إزالة الإشعار بعد 3 ثواني
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // إضافة أنيميشن للإشعارات
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideDown {
                from { transform: translateX(-50%) translateY(-100px); opacity: 0; }
                to { transform: translateX(-50%) translateY(0); opacity: 1; }
            }
            @keyframes slideUp {
                from { transform: translateX(-50%) translateY(0); opacity: 1; }
                to { transform: translateX(-50%) translateY(-100px); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>