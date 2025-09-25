<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company->name }} - Products</title>
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

        /* شريط التنقل العلوي */
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

        .search-bar {
            flex: 1;
            max-width: 500px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .search-bar input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-bar i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
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

        .nav-icon:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            transform: translateY(-2px);
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
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .company-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .company-name {
            font-size: 2.5em;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
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

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .product-description {
            color: #7f8c8d;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 1.5em;
            font-weight: 700;
            color: #27ae60;
        }

        .product-quantity {
            padding: 5px 12px;
            background: #ecf0f1;
            border-radius: 15px;
            font-size: 0.9em;
            color: #7f8c8d;
        }

        .product-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: 600;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .no-products {
            text-align: center;
            padding: 60px 20px;
            color: white;
        }

        .no-products i {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .companies-nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 40px;
        }

        .company-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: white;
            padding: 15px;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.1);
            min-width: 100px;
        }

        .company-nav-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-3px);
        }

        .company-nav-item.active {
            background: rgba(255,255,255,0.3);
            border: 2px solid white;
        }

        .company-nav-logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 8px;
        }

        .company-nav-name {
            font-size: 0.9em;
            text-align: center;
        }

        /* تنسيق خاص لشركة makeup 666 */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .category-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            text-align: center;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .category-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .category-title {
            padding: 20px;
            font-size: 1.5em;
            font-weight: 700;
            color: #2c3e50;
        }

        /* قسم عرض منتجات التصنيفات */
        .category-products-section {
            margin-top: 40px;
            display: none;
        }

        .category-products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            color: white;
        }

        .category-title-header {
            font-size: 2em;
            font-weight: 700;
        }

        .back-to-categories {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .back-to-categories:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        /* أنيميشن للإشعارات */
        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #27ae60;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1001;
            animation: slideDown 0.3s ease;
        }

        .notification-error {
            background: #e74c3c;
        }

        .notification-info {
            background: #3498db;
        }

        @keyframes slideDown {
            from { transform: translateX(-50%) translateY(-100px); opacity: 0; }
            to { transform: translateX(-50%) translateY(0); opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateX(-50%) translateY(0); opacity: 1; }
            to { transform: translateX(-50%) translateY(-100px); opacity: 0; }
        }

        @media (max-width: 768px) {
            .products-grid, .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .company-name {
                font-size: 2em;
            }
            
            .companies-nav {
                gap: 10px;
            }
            
            .company-nav-item {
                min-width: 80px;
                padding: 10px;
            }
            
            .nav-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-bar {
                max-width: 100%;
                order: 2;
            }
            
            .nav-icons {
                order: 1;
            }
        }
    </style>
</head>
<body>
    <!-- شريط التنقل العلوي -->
    <div class="top-navbar">
        <div class="nav-container">
            <div class="search-bar">
                <input type="text" placeholder="Search for products...">
                <i class="fas fa-search"></i>
            </div>
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
        <!-- Back Button -->
        <a href="javascript:history.back()" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Companies
        </a>

        <!-- Company Header -->
        <div class="header">
            <div class="company-info">
                @if($company->logo)
                    <img src="{{ asset('images/companies/' . $company->logo) }}" alt="{{ $company->name }}" class="company-logo">
                @else
                    <div class="company-logo" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5em;">
                        <i class="fas fa-building"></i>
                    </div>
                @endif
                <h1 class="company-name">{{ $company->name }}</h1>
            </div>
            <p style="font-size: 1.2em; opacity: 0.9;">Discover our amazing products</p>
        </div>

        <!-- Companies Navigation -->
        <div class="companies-nav">
            @foreach($companies as $comp)
                <a href="{{ route('companies.products', $comp) }}" 
                   class="company-nav-item {{ $comp->id == $company->id ? 'active' : '' }}">
                    @if($comp->logo)
                        <img src="{{ asset('images/companies/' . $comp->logo) }}" alt="{{ $comp->name }}" class="company-nav-logo">
                    @else
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-building" style="color: white;"></i>
                        </div>
                    @endif
                    <span class="company-nav-name">{{ Str::limit($comp->name, 12) }}</span>
                </a>
            @endforeach
        </div>

        <!-- عرض خاص لشركة makeup 666 -->
        @if(strtolower($company->name) === 'makeup 666')
            <!-- قسم التصنيفات -->
            <div id="categoriesSection" class="categories-grid">
                <div class="category-card" onclick="showCategoryProducts('cosmatic')">
                    <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Cosmetics" class="category-image">
                    <div class="category-title">Cosmetics</div>
                </div>
                <div class="category-card" onclick="showCategoryProducts('skin care')">
                    <img src="https://images.unsplash.com/photo-1600948836101-f9ffda59d250?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Skin Care" class="category-image">
                    <div class="category-title">Skin Care</div>
                </div>
                <div class="category-card" onclick="showCategoryProducts('makeup')">
                    <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Makeup" class="category-image">
                    <div class="category-title">Makeup</div>
                </div>
            </div>

            <!-- قسم عرض منتجات التصنيف -->
            <div id="categoryProductsSection" class="category-products-section">
                <div class="category-products-header">
                    <h2 class="category-title-header" id="categoryTitle">Cosmetics Products</h2>
                    <a href="javascript:void(0)" class="back-to-categories" onclick="showCategories()">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
                <div class="products-grid" id="categoryProductsGrid">
                    <!-- سيتم ملء المنتجات هنا بالJavaScript -->
                </div>
            </div>
        @else
            <!-- Products Grid للشركات الأخرى -->
            @if($products->count() > 0)
                <div class="products-grid" id="regularProductsGrid">
                    @foreach($products as $product)
                        <div class="product-card">
                            <span class="product-status {{ $product->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ $product->status == 'active' ? 'Available' : 'Out of Stock' }}
                            </span>
                            
                            @if($product->image)
                                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <div class="product-image" style="display: flex; align-items: center; justify-content: center; color: #7f8c8d;">
                                    <i class="fas fa-box" style="font-size: 3em;"></i>
                                </div>
                            @endif
                            
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                
                                @if($product->description)
                                    <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                                @endif
                                
                                <div class="product-details">
                                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                                    <div class="product-quantity">
                                        <i class="fas fa-cubes"></i> {{ $product->quantity }} in stock
                                    </div>
                                </div>
                                
                                <div style="display: flex; gap: 10px; margin-top: 15px;">
                                    @if($company->name==='nazleh closet')
                                    <a href="{{ route('prods.show', $product->id) }}" 
                                       class="view-btn" 
                                       style="padding: 12px 15px; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: flex; align-items: center;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @else
                                       <button onclick="addToCart({{ $product->id }})" 
                                            class="add-to-cart-btn"
                                            data-product-id="{{ $product->id }}"
                                            {{ !$product->is_available ? 'disabled' : '' }}
                                            style="flex: 1; padding: 12px; background: {{ $product->is_available ? '#27ae60' : '#95a5a6' }}; color: white; border: none; border-radius: 8px; cursor: {{ $product->is_available ? 'pointer' : 'not-allowed' }}; transition: all 0.3s ease;">
                                        <i class="fas fa-shopping-cart"></i> 
                                        {{ $product->is_available ? 'Add to Cart' : 'Out of Stock' }}
                                    </button>
                                    @endif
                                   <button class="wishlist-btn" 
                                        data-product-id="{{ $product->id }}"
                                        style="padding: 12px 15px; background: #f8f9fa; color: #e74c3c; border: 2px solid #e74c3c; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">
                                    <i class="fas fa-heart"></i>
                                </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <h2>No Products Available</h2>
                    <p>This company doesn't have any products yet.</p>
                </div>
            @endif
        @endif
    </div>

    <script>
        // بيانات منتجات makeup 666 (سيتم استبدالها ببيانات حقيقية من الخادم)
        const makeupProducts = [
            @foreach(\App\Models\MakeupProduct::where('company_id', $company->id)->get() as $product)
            {
                id: {{ $product->id }},
                name: "{{ $product->name }}",
                description: "{{ $product->description }}",
                price: {{ $product->price }},
                quantity: {{ $product->quantity }},
                status: "{{ $product->status }}",
                categ: "{{ $product->categ }}",
                image: "{{ $product->image ? asset('images/products/' . $product->image) : '' }}",
               // colors: "{{ $product->colors }}",
                is_available: {{ $product->status == 'active' && $product->quantity > 0 ? 'true' : 'false' }}
            },
            @endforeach
        ];

        // دالة عرض منتجات التصنيف
        function showCategoryProducts(category) {
            const categoryProducts = makeupProducts.filter(product => product.categ === category);
            
            // تحديث العنوان
            document.getElementById('categoryTitle').textContent = 
                category === 'cosmatic' ? 'Cosmetics Products' : 
                category === 'skin care' ? 'Skin Care Products' : 'Makeup Products';
            
            // عرض قسم المنتجات وإخفاء قسم التصنيفات
            document.getElementById('categoriesSection').style.display = 'none';
            document.getElementById('categoryProductsSection').style.display = 'block';
            
            // عرض المنتجات
            const productsGrid = document.getElementById('categoryProductsGrid');
            productsGrid.innerHTML = '';
            
            if (categoryProducts.length > 0) {
                categoryProducts.forEach(product => {
                    const productCard = createProductCard(product);
                    productsGrid.appendChild(productCard);
                });
            } else {
                productsGrid.innerHTML = `
                    <div class="no-products" style="grid-column: 1 / -1;">
                        <i class="fas fa-box-open"></i>
                        <h2>No ${category} Products Available</h2>
                        <p>No products found in this category.</p>
                    </div>
                `;
            }
            
            // إعادة تهيئة إدارة المفضلة للمنتجات الجديدة
            setTimeout(() => new WishlistManager('#categoryProductsGrid'), 100);
        }

        // دالة العودة للتصنيفات
        function showCategories() {
            document.getElementById('categoriesSection').style.display = 'grid';
            document.getElementById('categoryProductsSection').style.display = 'none';
        }

        // دالة إنشاء بطاقة منتج
        function createProductCard(product) {
            const card = document.createElement('div');
            card.className = 'product-card';
            card.innerHTML = `
                <span class="product-status ${product.status == 'active' ? 'status-active' : 'status-inactive'}">
                    ${product.status == 'active' ? 'Available' : 'Out of Stock'}
                </span>
                
                ${product.image ? 
                    `<img src="${product.image}" alt="${product.name}" class="product-image">` :
                    `<div class="product-image" style="display: flex; align-items: center; justify-content: center; color: #7f8c8d;">
                        <i class="fas fa-box" style="font-size: 3em;"></i>
                    </div>`
                }
                
                <div class="product-info">
                    <h3 class="product-name">${product.name}</h3>
                    
                    ${product.description ? 
                        `<p class="product-description">${product.description.length > 100 ? product.description.substring(0, 100) + '...' : product.description}</p>` : 
                        ''
                    }
                    
                    <div class="product-details">
                        <div class="product-price">$${product.price.toFixed(2)}</div>
                        <div class="product-quantity">
                            <i class="fas fa-cubes"></i> ${product.quantity} in stock
                        </div>
                    </div>
                    
                    ${product.colors ? 
                        `<div style="margin-bottom: 10px;">
                            <small class="text-muted">Colors: ${product.colors}</small>
                        </div>` : 
                        ''
                    }
                    
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <!-- زر المشاهدة -->
                        <a href="/products/makeup/${product.id}" 
                           class="view-btn" 
                           style="padding: 12px 15px; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <button onclick="addToCart(${product.id})" 
                            class="add-to-cart-btn"
                            data-product-id="${product.id}"
                            ${!product.is_available ? 'disabled' : ''}
                            style="flex: 1; padding: 12px; background: ${product.is_available ? '#27ae60' : '#95a5a6'}; color: white; border: none; border-radius: 8px; cursor: ${product.is_available ? 'pointer' : 'not-allowed'}; transition: all 0.3s ease;">
                            <i class="fas fa-shopping-cart"></i> 
                            ${product.is_available ? 'Add to Cart' : 'Out of Stock'}
                        </button>
                        
                        <button class="wishlist-btn" 
                            data-product-id="${product.id}"
                            style="padding: 12px 15px; background: #f8f9fa; color: #e74c3c; border: 2px solid #e74c3c; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            `;
            
            return card;
        }

        // دالة إضافة إلى السلة
        async function addToCart(productId) {
            const button = document.querySelector(`[data-product-id="${productId}"]`);
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
                        quantity: 1
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    updateCartBadge(data.cart_count);
                    showNotification('Product added to cart successfully!', 'success');
                    
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
        async function updateCartBadge(count = null) {
            try {
                if (count === null) {
                    const response = await fetch('{{ route("cart.count") }}');
                    const data = await response.json();
                    count = data.cart_count;
                }
                
                document.getElementById('cart-badge').textContent = count;
                
                const badge = document.getElementById('cart-badge');
                badge.parentElement.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    badge.parentElement.style.transform = 'scale(1)';
                }, 300);
                
            } catch (error) {
                console.error('Error updating cart badge:', error);
            }
        }

        // دالة إظهار الإشعارات
        function showNotification(message, type = 'info') {
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
            
            if (type === 'error') {
                notification.classList.add('notification-error');
            } else if (type === 'info') {
                notification.classList.add('notification-info');
            }
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // كلاس إدارة المفضلة المحسّن
        class WishlistManager {
            constructor(containerSelector = null) {
                this.container = containerSelector ? document.querySelector(containerSelector) : document;
                this.buttons = this.container.querySelectorAll('.wishlist-btn');
                this.init();
            }

            init() {
                this.buttons.forEach(btn => {
                    const productId = btn.dataset.productId;
                    this.checkFavoriteStatus(btn, productId);
                    this.addEventListeners(btn, productId);
                });
            }

            async checkFavoriteStatus(btn, productId) {
                try {
                    const response = await fetch(`/favorites/check/${productId}`);
                    const data = await response.json();
                    
                    if (data.success) {
                        this.updateButtonStyle(btn, data.is_favorite);
                    }
                } catch (error) {
                    console.error('Error checking favorite status:', error);
                }
            }

            addEventListeners(btn, productId) {
                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    await this.toggleFavorite(btn, productId);
                });
            }

            async toggleFavorite(btn, productId) {
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
                        this.updateButtonStyle(btn, data.is_favorite);
                        showNotification(data.message, data.is_favorite ? 'success' : 'info');
                        this.updateFavoritesBadge(data.favorites_count);
                    } else {
                        if (data.login_required) {
                            this.showLoginModal();
                        } else {
                            showNotification(data.message, 'error');
                        }
                    }
                } catch (error) {
                    console.error('Error toggling favorite:', error);
                    showNotification('An error occurred', 'error');
                }
            }

            updateButtonStyle(btn, isFavorite) {
                if (isFavorite) {
                    btn.style.background = '#e74c3c';
                    btn.style.color = 'white';
                    btn.style.borderColor = '#e74c3c';
                    btn.innerHTML = '<i class="fas fa-heart"></i>';
                } else {
                    btn.style.background = '#f8f9fa';
                    btn.style.color = '#e74c3c';
                    btn.style.borderColor = '#e74c3c';
                    btn.innerHTML = '<i class="far fa-heart"></i>';
                }
            }

            async updateFavoritesBadge(count = null) {
                try {
                    if (count === null) {
                        const response = await fetch('/favorites/count');
                        const data = await response.json();
                        count = data.favorites_count;
                    }
                    
                    document.getElementById('favorites-badge').textContent = count;
                    
                    const badge = document.getElementById('favorites-badge');
                    badge.parentElement.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        badge.parentElement.style.transform = 'scale(1)';
                    }, 300);
                    
                } catch (error) {
                    console.error('Error updating favorites badge:', error);
                }
            }

            showLoginModal() {
                alert('Please login to add to favorites');
            }
        }

        // تهيئة الصفحة عند التحميل
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
            
            // تهيئة المفضلة للمنتجات العادية
            if (!document.getElementById('categoriesSection') || document.getElementById('categoriesSection').style.display !== 'none') {
                new WishlistManager('#regularProductsGrid');
            }
            
            // تحديث عداد المفضلة
            setTimeout(() => {
                const wishlistManager = new WishlistManager();
                wishlistManager.updateFavoritesBadge();
            }, 500);
            
            // تأثيرات التمرير
            const cards = document.querySelectorAll('.product-card, .category-card');
            const navItems = document.querySelectorAll('.company-nav-item');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>