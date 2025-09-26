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
            background: linear-gradient(135deg, #f1f2f8ff 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .top-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .nav-icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-icon {
            position: relative;
            color: #2c3e50;
            text-decoration: none;
            font-size: 1.3em;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7em;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
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
            margin-bottom: 30px;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .product-details-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .product-images {
            position: relative;
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .thumbnails-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail:hover, .thumbnail.active {
            border-color: #667eea;
            transform: scale(1.1);
        }

        .product-info {
            padding: 40px;
        }

        .product-category {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .product-title {
            font-size: 2.5em;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .product-price {
            font-size: 2em;
            font-weight: 700;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .product-description {
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 1.1em;
        }

        .product-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .meta-icon {
            color: #667eea;
            font-size: 1.2em;
        }

        /* قسم اختيار الألوان */
        .colors-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 1.2em;
        }

        .colors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }

        .color-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .color-option:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .color-option.selected {
            border-color: #27ae60;
            background: #f0fff4;
        }

        .color-sample {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-bottom: 8px;
            border: 2px solid #ddd;
        }

        .color-name {
            font-size: 0.9em;
            color: #2c3e50;
            font-weight: 500;
            text-align: center;
        }

        /* قسم الكمية */
        .quantity-section {
            margin-bottom: 30px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #667eea;
            color: white;
        }

        .quantity-input {
            width: 80px;
            text-align: center;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary {
            background: #27ae60;
            color: white;
        }

        .btn-primary:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-secondary {
            background: #3498db;
            color: white;
        }

        .btn-secondary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #e74c3c;
            color: #e74c3c;
        }

        .btn-outline:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-2px);
        }

        .btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .selected-options {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #27ae60;
        }

        .selected-options p {
            margin: 5px 0;
            color: #2c3e50;
        }

        @media (max-width: 768px) {
            .product-details-container {
                grid-template-columns: 1fr;
            }
            
            .product-info {
                padding: 20px;
            }
            
            .product-title {
                font-size: 2em;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .colors-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- شريط التنقل العلوي -->
    <div class="top-navbar">
        <div class="nav-container">
            <a href="{{ route('companies.products', $company) }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to {{ $company->name }}
            </a>
            <div class="nav-icons">
                <a href="{{ route('cart.index') }}" class="nav-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-badge" class="badge">0</span>
                </a>
                <a href="{{ route('favorites.index') }}" class="nav-icon">
                    <i class="fas fa-heart"></i>
                    <span id="favorites-badge" class="badge">0</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="product-details-container">
            <!-- قسم الصور -->
            <div class="product-images">
                @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="main-image" 
                         id="mainImage">
                @else
                    <div class="main-image" style="display: flex; align-items: center; justify-content: center; color: #7f8c8d;">
                        <i class="fas fa-box" style="font-size: 4em;"></i>
                    </div>
                @endif
                
                <!-- الصور الإضافية -->
                <div class="thumbnails-container">
                    <!-- الصورة الرئيسية كأول thumbnail -->
                    @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="thumbnail active"
                             onclick="changeMainImage('{{ asset('images/products/' . $product->image) }}', this)">
                    @endif
                    
                    <!-- الصور الإضافية -->
                    @if($product->additional_images)
                        @foreach(json_decode($product->additional_images) as $index => $additionalImage)
                            <img src="{{ asset('images/products/additional/' . $additionalImage) }}" 
                                 alt="Additional image {{ $index + 1 }}" 
                                 class="thumbnail"
                                 onclick="changeMainImage('{{ asset('images/products/additional/' . $additionalImage) }}', this)">
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- قسم المعلومات -->
            <div class="product-info">
                <span class="status-badge {{ $product->status == 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ $product->status == 'active' ? 'Available' : 'Out of Stock' }}
                </span>
                
                <span class="product-category">{{ $product->categ }}</span>
                
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                
                @if($product->description)
                    <p class="product-description">{{ $product->description }}</p>
                @endif

                <div class="product-meta">
                    <div class="meta-item">
                        <i class="fas fa-cubes meta-icon"></i>
                        <div>
                            <div class="meta-label">Quantity</div>
                            <div class="meta-value">{{ $product->quantity }} in stock</div>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-tags meta-icon"></i>
                        <div>
                            <div class="meta-label">Category</div>
                            <div class="meta-value">{{ $product->categ }}</div>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-building meta-icon"></i>
                        <div>
                            <div class="meta-label">Company</div>
                            <div class="meta-value">{{ $company->name }}</div>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-calendar meta-icon"></i>
                        <div>
                            <div class="meta-label">Added</div>
                            <div class="meta-value">{{ $product->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- قسم اختيار الألوان -->
                @if($product->colors)
                <div class="colors-section">
                    <div class="section-title">Choose Color:</div>
                    <div class="colors-grid" id="colorsGrid">
                        @foreach(explode(',', $product->colors) as $color)
                            @php
                                $colorName = trim($color);
                                $colorCode = getColorCode($colorName); // دالة مساعدة للحصول على كود اللون
                            @endphp
                            <div class="color-option" data-color="{{ $colorName }}" onclick="selectColor('{{ $colorName }}', this)">
                                <div class="color-sample" style="background-color: {{ $colorCode }};"></div>
                                <span class="color-name">{{ $colorName }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- قسم اختيار الكمية -->
                <div class="quantity-section">
                    <div class="section-title">Quantity:</div>
                    <div class="quantity-selector">
                        <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantityInput" class="quantity-input" value="1" min="1" max="{{ $product->quantity }}">
                        <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                    </div>
                </div>

                <!-- الخيارات المختارة -->
                <div class="selected-options" id="selectedOptions" style="display: none;">
                    <p><strong>Selected Options:</strong></p>
                    <p id="selectedColorText"></p>
                    <p id="selectedQuantityText"></p>
                </div>

                <div class="action-buttons">
                    <button onclick="addToCart({{ $product->id }})" 
                            class="btn btn-primary"
                            {{ !$product->is_available ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart"></i>
                        {{ $product->is_available ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                    
                    <button class="btn btn-secondary" onclick="toggleFavorite({{ $product->id }})" id="favoriteBtn">
                        <i class="far fa-heart" id="favoriteIcon"></i>
                        Add to Wishlist
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // المتغيرات العامة
        let selectedColor = null;
        let selectedQuantity = 1;

        // دالة تغيير الصورة الرئيسية
        function changeMainImage(imageUrl, element) {
            document.getElementById('mainImage').src = imageUrl;
            
            // تحديث الصورة النشطة
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }

        // دالة اختيار اللون
        function selectColor(colorName, element) {
            // إلغاء تحديد جميع الألوان
            document.querySelectorAll('.color-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // تحديد اللون الجديد
            element.classList.add('selected');
            selectedColor = colorName;
            
            // تحديث الخيارات المختارة
            updateSelectedOptions();
        }

        // دالة زيادة الكمية
        function increaseQuantity() {
            const input = document.getElementById('quantityInput');
            const maxQuantity = {{ $product->quantity }};
            
            if (parseInt(input.value) < maxQuantity) {
                input.value = parseInt(input.value) + 1;
                selectedQuantity = input.value;
                updateSelectedOptions();
            }
        }

        // دالة تقليل الكمية
        function decreaseQuantity() {
            const input = document.getElementById('quantityInput');
            
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                selectedQuantity = input.value;
                updateSelectedOptions();
            }
        }

        // تحديث حقل الكمية يدوياً
        document.getElementById('quantityInput').addEventListener('change', function() {
            const maxQuantity = {{ $product->quantity }};
            let value = parseInt(this.value);
            
            if (value < 1) value = 1;
            if (value > maxQuantity) value = maxQuantity;
            
            this.value = value;
            selectedQuantity = value;
            updateSelectedOptions();
        });

        // دالة تحديث الخيارات المختارة
        function updateSelectedOptions() {
            const selectedOptions = document.getElementById('selectedOptions');
            const selectedColorText = document.getElementById('selectedColorText');
            const selectedQuantityText = document.getElementById('selectedQuantityText');
            
            let optionsHTML = '';
            
            if (selectedColor) {
                optionsHTML += `<p><strong>Color:</strong> ${selectedColor}</p>`;
            }
            
            optionsHTML += `<p><strong>Quantity:</strong> ${selectedQuantity}</p>`;
            
            selectedColorText.innerHTML = selectedColor ? `<strong>Color:</strong> ${selectedColor}` : '';
            selectedQuantityText.innerHTML = `<strong>Quantity:</strong> ${selectedQuantity}`;
            
            if (selectedColor) {
                selectedOptions.style.display = 'block';
            } else {
                selectedOptions.style.display = 'none';
            }
        }

        // دالة إضافة إلى السلة مع الخيارات
        async function addToCart(productId) {
            const button = document.querySelector('.btn-primary');
            const originalText = button.innerHTML;
            
            // التحقق من اختيار اللون إذا كان متوفراً
            if (selectedColor === null && '{{ $product->colors }}' !== '') {
                showNotification('Please select a color before adding to cart', 'error');
                return;
            }
            
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
                        quantity: selectedQuantity,
                        color: selectedColor,
                        product_type: 'makeup'
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    updateCartBadge(data.cart_count);
                    showNotification('Product added to cart successfully!', 'success');
                    
                    button.innerHTML = '<i class="fas fa-check"></i> Added!';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = !{{ $product->is_available ? 'true' : 'false' }};
                    }, 2000);
                    
                } else {
                    throw new Error(data.message);
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to add product to cart', 'error');
                button.innerHTML = originalText;
                button.disabled = !{{ $product->is_available ? 'true' : 'false' }};
            }
        }

        // دالة المفضلة
        async function toggleFavorite(productId) {
            const button = document.getElementById('favoriteBtn');
            const icon = document.getElementById('favoriteIcon');
            
            try {
                const response = await fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();

                if (data.success) {
                    if (data.is_favorite) {
                        icon.className = 'fas fa-heart';
                        button.style.background = '#e74c3c';
                        showNotification('Added to favorites!', 'success');
                    } else {
                        icon.className = 'far fa-heart';
                        button.style.background = '#3498db';
                        showNotification('Removed from favorites', 'info');
                    }
                } else {
                    if (data.login_required) {
                        showNotification('Please login to add to favorites', 'error');
                    } else {
                        showNotification(data.message, 'error');
                    }
                }
            } catch (error) {
                console.error('Error toggling favorite:', error);
                showNotification('An error occurred', 'error');
            }
        }

        // دالة تحديث عداد السلة
        async function updateCartBadge(count = null) {
            try {
                if (count === null) {
                    const response = await fetch('{{ route("cart.count") }}');
                    const data = await response.json();
                    count = data.cart_count;
                }
                
                document.getElementById('cart-badge').textContent = count;
                
            } catch (error) {
                console.error('Error updating cart badge:', error);
            }
        }

        // دالة الإشعارات
        function showNotification(message, type = 'info') {
            // إزالة أي إشعارات سابقة
            const existingNotification = document.querySelector('.custom-notification');
            if (existingNotification) {
                existingNotification.remove();
            }
            
            const notification = document.createElement('div');
            notification.className = `custom-notification`;
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
                font-weight: 500;
            `;
            notification.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> ${message}`;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // تهيئة الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
            selectedQuantity = 1;
            updateSelectedOptions();
        });
    </script>
</body>
</html>

<?php
// دالة مساعدة للحصول على كود اللون (يمكن وضعها في helper file)
function getColorCode($colorName) {
    $colorMap = [
        'أحمر' => '#FF0000',
        'red' => '#FF0000',
        'وردي' => '#FFC0CB',
        'pink' => '#FFC0CB',
        'بني' => '#A52A2A',
        'brown' => '#A52A2A',
        'أسود' => '#000000',
        'black' => '#000000',
        'أبيض' => '#FFFFFF',
        'white' => '#FFFFFF',
        'أزرق' => '#0000FF',
        'blue' => '#0000FF',
        'أخضر' => '#008000',
        'green' => '#008000',
        'ذهبي' => '#FFD700',
        'gold' => '#FFD700',
        'فضي' => '#C0C0C0',
        'silver' => '#C0C0C0',
        'برتقالي' => '#FFA500',
        'orange' => '#FFA500',
        'بنفسجي' => '#800080',
        'purple' => '#800080',
    ];
    
    return $colorMap[strtolower($colorName)] ?? '#CCCCCC';
}
?>