<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company->name }} - Products</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* جميع الأنماط السابقة تبقى كما هي */
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

        /* ... باقي الأنماط تبقى كما هي بدون تغيير ... */
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
        // بيانات منتجات makeup 666
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
                colors: "{{ $product->colors }}",
                is_available: {{ $product->status == 'active' && $product->quantity > 0 ? 'true' : 'false' }}
            },
            @endforeach
        ];

        // دالة عرض منتجات التصنيف
        function showCategoryProducts(category) {
            const categoryProducts = makeupProducts.filter(product => product.categ === category);
            
            document.getElementById('categoryTitle').textContent = 
                category === 'cosmatic' ? 'Cosmetics Products' : 
                category === 'skin care' ? 'Skin Care Products' : 'Makeup Products';
            
            document.getElementById('categoriesSection').style.display = 'none';
            document.getElementById('categoryProductsSection').style.display = 'block';
            
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
                    const response = await fetch('{{ route("favorites.toggle") }}', {
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
                
                // تأثير عند التغيير
                btn.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                }, 300);
            }

            async updateFavoritesBadge(count = null) {
                try {
                    if (count === null) {
                        // استخدام المسار الصحيح من المتحكم
                        const response = await fetch('{{ route("favorites.count") }}');
                        const data = await response.json();
                        count = data.favorites_count;
                    }
                    
                    const badge = document.getElementById('favorites-badge');
                    if (badge) {
                        badge.textContent = count;
                        
                        badge.parentElement.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            badge.parentElement.style.transform = 'scale(1)';
                        }, 300);
                    }
                    
                } catch (error) {
                    console.error('Error updating favorites badge:', error);
                }
            }

            showLoginModal() {
                if (confirm('Please login to add to favorites. Would you like to login now?')) {
                    window.location.href = '{{ route("login") }}';
                }
            }
        }

        // دالة لتحميل عدد المفضلات عند بدء التشغيل
        async function loadInitialFavoritesCount() {
            try {
                const response = await fetch('{{ route("favorites.count") }}');
                const data = await response.json();
                document.getElementById('favorites-badge').textContent = data.favorites_count;
            } catch (error) {
                console.error('Error loading favorites count:', error);
            }
        }

        // تهيئة الصفحة عند التحميل
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
            loadInitialFavoritesCount();
            
            // تهيئة المفضلة للمنتجات العادية
            new WishlistManager('#regularProductsGrid');
            
            // تأثيرات التمرير
            const cards = document.querySelectorAll('.product-card, .category-card');
            
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