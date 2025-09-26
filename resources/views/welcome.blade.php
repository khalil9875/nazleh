@extends('layouts.app')

@section('content')

<style>
    .hero-slider {
        position: relative;
        margin-top:200px;
        height: 700px;
        overflow: hidden;
        margin-bottom: -400px;
    }

    .slide {
        margin-left: 325px;
        margin-top: 100px;
        position: absolute;
        top: 0;
        left: 0;
        width: 60%;
        height: 95%;
        opacity: 0;
        transition: opacity 1s ease;
    }

    .slide.active {
        opacity: 1;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slide-content {
        position: absolute;
        bottom: 50px;
        right: 50px;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        max-width: 500px;
    }

    .slide-content h2 {
        font-size: 36px;
        margin-bottom: 15px;
    }

    .slide-content p {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .slider-nav {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
    }

    .slider-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        cursor: pointer;
        transition: var(--transition);
    }

    .slider-dot.active {
        background: white;
        transform: scale(1.2);
    }

    /* تحسينات قسم الأصناف */
    .categories-horizontal {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
        margin-top: 50px;
    }
    
    .brand-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        flex: 0 0 calc(25% - 30px);
        max-width: calc(25% - 30px);
        display: flex;
        flex-direction: column;
        position: relative;
        cursor: pointer;
    }
    
    .brand-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .brand-image {
        width: 100%;
        height: 250px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px;
    }
    
    .brand-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.5s ease;
        border-radius: 12px; /* إضافة انحناء للزوايا */
    }
    
    .brand-card:hover .brand-image img {
        transform: scale(1.08);
    }
    
    .brand-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(58, 134, 255, 0.1) 0%, rgba(131, 56, 236, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    
    .brand-card:hover .brand-overlay {
        opacity: 1;
    }
    
    .brand-content {
        padding: 20px;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .brand-content h3 {
        font-size: 1.3rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    
    .brand-content p {
        color: #7f8c8d;
        font-size: 0.95rem;
    }
    
    /* تصميم متجاوب */
    @media (max-width: 992px) {
        .brand-card {
            flex: 0 0 calc(50% - 30px);
            max-width: calc(50% - 30px);
        }
    }
    
    @media (max-width: 768px) {
        .brand-card {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .section-header h2 {
            font-size: 2rem;
        }
        
        .brand-image {
            height: 200px;
            padding: 20px;
        }
    }

    /* أنماط Footer مشابه لـ Nazleh */
    .footer {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: #ecf0f1;
        padding: 60px 0 20px;
        margin-top: 100px;
    }
    
    .footer-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 40px;
        margin-bottom: 40px;
    }
    
    .footer-section {
        flex: 1;
        min-width: 250px;
    }
    
    .footer-section h3 {
        color: #3498db;
        margin-bottom: 20px;
        font-size: 1.4rem;
        position: relative;
        padding-bottom: 10px;
    }
    
    .footer-section h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: #3498db;
        border-radius: 2px;
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
    }
    
    .footer-links li {
        margin-bottom: 12px;
    }
    
    .footer-links a {
        color: #bdc3c7;
        text-decoration: none;
        transition: color 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .footer-links a:hover {
        color: #3498db;
        transform: translateX(5px);
    }
    
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(52, 152, 219, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    
    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        background: rgba(52, 152, 219, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ecf0f1;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .social-link:hover {
        background: #3498db;
        transform: translateY(-3px);
    }
    
    .footer-bottom {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #95a5a6;
        font-size: 0.9rem;
    }
    
    .newsletter-form {
        display: flex;
        margin-top: 20px;
    }
    
    .newsletter-input {
        flex: 1;
        padding: 12px 15px;
        border: none;
        border-radius: 5px 0 0 5px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .newsletter-input::placeholder {
        color: #bdc3c7;
    }
    
    .newsletter-btn {
        padding: 12px 20px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .newsletter-btn:hover {
        background: #2980b9;
    }

    /* باقي الأنماط الحالية */
    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(58, 134, 255, 0.1) 0%, rgba(131, 56, 236, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .category-card:hover::before {
        opacity: 1;
    }

    .category-content {
        position: relative;
        z-index: 2;
    }

    .category-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-card:hover .category-image::after {
        opacity: 1;
    }
    
    .categories {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .category-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    .category-image {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-image img {
        transform: scale(1.1);
    }

    /* باقي الأنماط الحالية تبقى كما هي */
</style>

</header>


<!-- Categories Section -->
<section id="categories" class="categories" style="margin-top:200px;">
    <div class="container">
        <div class="section-header">
            <h2>
Because You Deserve the Best
            </h2>
            <p>
Choose from our handpicked collection of jewelry, fashion, perfume and makeup for your most stunning look            </p>
        </div>
        
        <!-- التصميم المحسن للصور بشكل أفقي -->
        <div class="categories-horizontal">
            <div class="brand-card" data-category="brand1" onclick="filterProducts('Makeup 666')">
                <div class="brand-overlay"></div>
                <div class="brand-image">
                    <img src="images/1.png" alt="العلامة التجارية الأولى">
                </div>
               
            </div>
            
            <div class="brand-card" data-category="brand2" onclick="filterProducts('Nazleh Jewellery')">
                <div class="brand-overlay"></div>
                <div class="brand-image">
                    <img src="images/2.png" alt="العلامة التجارية الثانية">
                </div>
               
            </div>
            
            <div class="brand-card" data-category="brand3" onclick="filterProducts('Nazleh Ounce')">
                <div class="brand-overlay"></div>
                <div class="brand-image">
                    <img src="images/3.png" alt="العلامة التجارية الثالثة">
                </div>
                
            </div>
             <div class="brand-card" data-category="brand3" onclick="filterProducts('Nazleh Ounce')">
                <div class="brand-overlay"></div>
                <div class="brand-image">
                    <img src="images/4.png" alt="العلامة التجارية الثالثة">
                </div>
                
            </div>
        </div>
    </div>
</section>
<style>
    /* تنسيقات الفوتر الجديدة بأناقة واحترافية */
    .footer-07 {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        padding: 70px 0 30px;
        margin-top: 500px;
        position: relative;
        overflow: hidden;
    }

    .footer-07::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #3498db, transparent);
    }

    .footer-heading {
        font-size: 3rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 30px;
        font-family: 'Playfair Display', serif;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        position: relative;
    }

    .footer-heading::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #3498db, #9b59b6);
        border-radius: 2px;
    }

    .ftco-footer-social {
        display: flex;
        gap: 25px;
        margin-bottom: 40px;
    }

    .ftco-footer-social li {
        list-style: none;
    }

    .ftco-footer-social a {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .ftco-footer-social a:hover {
        background: #3498db;
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
    }

    .footer-menu {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 35px;
        margin-bottom: 40px;
        padding: 0;
    }

    .footer-menu li {
        list-style: none;
    }

    .footer-menu a {
        color: #bdc3c7;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 8px 0;
        position: relative;
    }

    .footer-menu a::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #3498db, #9b59b6);
        transition: width 0.3s ease;
    }

    .footer-menu a:hover {
        color: #ffffff;
    }

    .footer-menu a:hover::before {
        width: 100%;
    }

    .footer-install-cta {
        margin: 30px 0;
        background: rgba(255, 255, 255, 0.05);
        padding: 15px 25px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    #footer-install-link {
        color: #ecf0f1;
        text-decoration: none;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }

    #footer-install-link:hover {
        color: #3498db;
        transform: translateX(5px);
    }

    .footer-copyright {
        color: #95a5a6;
        font-size: 0.95rem;
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .footer-link {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
    }

    .footer-link:hover {
        color: #9b59b6;
        text-decoration: none;
    }

    .footer-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 1px;
        background: #9b59b6;
        transition: width 0.3s ease;
    }

    .footer-link:hover::after {
        width: 100%;
    }

    /* تأثيرات إضافية للاحترافية */
    .ftco-animate {
        animation-duration: 0.5s;
        animation-fill-mode: both;
    }

    .container-lg {
        position: relative;
        z-index: 2;
    }

    /* تحسينات التجاوب */
    @media (max-width: 768px) {
        .footer-07 {
            padding: 50px 0 20px;
            margin-top: 300px;
        }

        .footer-heading {
            font-size: 2.2rem;
            margin-bottom: 25px;
        }

        .ftco-footer-social {
            gap: 15px;
            margin-bottom: 30px;
        }

        .ftco-footer-social a {
            width: 45px;
            height: 45px;
        }

        .footer-menu {
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .footer-menu a {
            font-size: 0.95rem;
        }

        .footer-install-cta {
            padding: 12px 20px;
            margin: 25px 0;
        }

        #footer-install-link {
            font-size: 0.9rem;
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .footer-heading {
            font-size: 1.8rem;
        }
        
        .ftco-footer-social {
            gap: 12px;
        }
        
        .ftco-footer-social a {
            width: 40px;
            height: 40px;
        }
    }
</style>

<footer class="footer-07">
    <div class="container-lg justify-content-center">
        <div class="d-flex flex-column align-items-center text-center">
            <h2 class="footer-heading">
                Nazleh
            </h2>

            <ul class="ftco-footer-social p-0">
                <li class="ftco-animate">
                    <a href="#" title="Facebook" target="_blank">
                        <span class="fab fa-facebook-f"></span>
                    </a>
                </li>
                <li class="ftco-animate">
                    <a href="#nazleh.jewelry" title="Instagram" target="_blank">
                        <span class="fab fa-instagram"></span>
                    </a>
                </li>
                <li class="ftco-animate">
                    <a href="#" title="Youtube" target="_blank">
                        <span class="fab fa-youtube"></span>
                    </a>
                </li>
            </ul>

            <ul class="footer-menu">
                <li><a href="/en/privacy-policy">Privacy Policy</a></li>
                <li><a href="/en/delivery-information">Delivery Information</a></li>
                <li><a href="/en/refund-cancelation-return-policy">Refund, Cancelation &amp; Return Policy</a></li>
                <li><a href="/en/terms-conditions">Terms &amp; Conditions</a></li>
            </ul>

            <img src="/images/m5.png" alt="payments" style="height: 45px;" class="mb-3">

            
            
            <p class="footer-copyright mb-2">
                ©2025 <a class="footer-link" href="https://nazleh.com/en">Nazleh</a>. All Rights Reserved. Powered by
                <a class="footer-link" rel="noopener noreferrer nofollow" href="https://matjary.ae/en/" target="_blank">Matjary</a>.
            </p>
        </div>
    </div>
</footer>

<script>
       function myfunc(){
            var prod=document.getElementById("products");
         var cats=document.getElementById("categories");
           cats.style.display="none";
            prod.style.display="block";
               alert('done');
        }
</script>
@endsection

@section('modals')
    @include('partials.product-modal')
@endsection

@section('scripts')
    <script>
     
        // Update the API base URL for Laravel
        const API_BASE_URL = '/api';
        
        // Sample data for demonstration
        const categoriesData = [
            { id: 1, name: "Makeup 666", icon: "fa-palette", description: "Premium cosmetics and beauty products", products: 42 },
            { id: 2, name: "Nazleh Jewellery", icon: "fa-gem", description: "Exclusive gold and diamond jewelry", products: 35 },
            { id: 3, name: "Nazleh Ounce", icon: "fa-coins", description: "Investment-grade gold and precious metals", products: 18 },
            { id: 4, name: "Nazleh Clothes", icon: "fa-tshirt", description: "Luxury fashion and apparel", products: 67 },
            { id: 5, name: "The Kanz", icon: "fa-spray-can", description: "Premium perfumes and fragrances", products: 29 }
        ];
        
        const productsData = [
            { id: 1, name: "Luxury Gold Necklace", price: 299.99, originalPrice: 399.99, category: "Nazleh Jewellery", image: "/images/products/jewelry-1.jpg", rating: 4.8, reviews: 42, description: "Exquisite 18K gold necklace with diamond accents. Handcrafted by master jewelers for exceptional quality and brilliance." },
            { id: 2, name: "Premium Makeup Kit", price: 149.99, originalPrice: 199.99, category: "Makeup 666", image: "/images/products/makeup-1.jpg", rating: 4.5, reviews: 37, description: "Complete professional makeup set with premium brushes and high-pigment colors. Perfect for everyday use and special occasions." },
            { id: 3, name: "Designer Evening Gown", price: 459.99, originalPrice: 599.99, category: "Nazleh Clothes", image: "/images/products/clothing-1.jpg", rating: 4.9, reviews: 28, description: "Elegant evening gown made from the finest silk with intricate embroidery. Designed for sophistication and comfort." },
            { id: 4, name: "Exclusive Perfume Collection", price: 199.99, originalPrice: 249.99, category: "The Kanz", image: "/images/products/perfume-1.jpg", rating: 4.7, reviews: 53, description: "Luxury fragrance set with three distinct scents for different occasions. Long-lasting and captivating aromas." },
            { id: 5, name: "Gold Investment Bar", price: 1999.99, originalPrice: 2099.99, category: "Nazleh Ounce", image: "/images/products/gold-1.jpg", rating: 4.9, reviews: 19, description: "24K pure gold bar with certificate of authenticity. Ideal for investment and wealth preservation." },
            { id: 6, name: "Diamond Earrings", price: 599.99, originalPrice: 749.99, category: "Nazleh Jewellery", image: "/images/products/jewelry-2.jpg", rating: 4.8, reviews: 31, description: "Brilliant cut diamond earrings set in white gold. Perfect for adding sparkle to any outfit." },
            { id: 7, name: "Skincare Luxury Set", price: 129.99, originalPrice: 159.99, category: "Makeup 666", image: "/images/products/skincare-1.jpg", rating: 4.6, reviews: 46, description: "Complete skincare regimen with anti-aging properties. Nourishes and revitalizes your skin for a youthful glow." },
            { id: 8, name: "Silk Scarf Collection", price: 89.99, originalPrice: 119.99, category: "Nazleh Clothes", image: "/images/products/accessory-1.jpg", rating: 4.4, reviews: 24, description: "Luxury silk scarves with exclusive patterns. Hand-rolled edges and premium quality fabric for elegance." }
        ];
        
        // DOM Elements
        const navMenu = document.getElementById('nav-menu');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const cartOverlay = document.getElementById('cart-overlay');
        const cartSidebar = document.getElementById('cart-sidebar');
        const modalOverlay = document.getElementById('modal-overlay');
        const productModal = document.getElementById('product-modal');
        const categoriesGrid = document.getElementById('categories-grid');
        const productsGrid = document.getElementById('products-grid');
        const cartItems = document.getElementById('cart-items');
        const emptyCart = document.getElementById('empty-cart');
        const cartCount = document.getElementById('cart-count');
        const cartTotal = document.getElementById('cart-total');
        const searchInput = document.getElementById('search-input');
        
        // Initialize cart
        let cart = JSON.parse(localStorage.getItem('nazleh_cart')) || [];
        updateCartCount();
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            renderCategories();
            renderProducts();
            initScrollEffects();
            initMobileMenu();
            updateEmptyCartVisibility();
        });
        
        // Render categories
        function renderCategories() {
            categoriesGrid.innerHTML = '';
            
            categoriesData.forEach(category => {
                const categoryCard = document.createElement('div');
                categoryCard.className = 'category-card fade-in';
                categoryCard.innerHTML = `
                    <div class="category-image">
                        <i class="fas ${category.icon}"></i>
                    </div>
                    <div class="category-content">
                        <h3>${category.name}</h3>
                        <p>${category.description}</p>
                        <a href="#" class="category-link" onclick="filterProducts('${category.name}')">
                            Explore <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                `;
                categoriesGrid.appendChild(categoryCard);
            });
        }
        
        // Render products
        function renderProducts(products = productsData) {
            productsGrid.innerHTML = '';
            
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card fade-in';
                productCard.innerHTML = `
                    ${product.originalPrice ? `<span class="product-badge">Sale</span>` : ''}
                    <div class="product-image">
                        <img src="${product.image}" alt="${product.name}">
                        <div class="product-actions">
                            <button class="action-btn" onclick="addToCart(${product.id})">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            <button class="action-btn" onclick="viewProduct(${product.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">${product.name}</h3>
                        <div class="product-price">
                            <span class="current-price">$${product.price.toFixed(2)}</span>
                            ${product.originalPrice ? `<span class="original-price">$${product.originalPrice.toFixed(2)}</span>` : ''}
                        </div>
                        <div class="product-rating">
                            <div class="stars">
                                ${getStarRating(product.rating)}
                            </div>
                            <span class="rating-count">(${product.reviews})</span>
                        </div>
                        <button class="add-to-cart-btn" onclick="addToCart(${product.id})">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                `;
                productsGrid.appendChild(productCard);
            });
        }
        
        // Get star rating HTML
        function getStarRating(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            
            for (let i = 0; i < fullStars; i++) {
                stars += '<i class="fas fa-star"></i>';
            }
            
            if (hasHalfStar) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            }
            
            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                stars += '<i class="far fa-star"></i>';
            }
            
            return stars;
        }
        
        // Filter products by category
        function filterProducts(category) {
            const filteredProducts = productsData.filter(product => product.category === category);
            renderProducts(filteredProducts);
            scrollToSection('products');
        }
        
        // View product details
        function viewProduct(productId) {
            const product = productsData.find(p => p.id === productId);
            if (product) {
                document.getElementById('modal-product-name').textContent = product.name;
                document.getElementById('modal-product-image').src = product.image;
                document.getElementById('modal-product-price').textContent = product.price.toFixed(2);
                document.getElementById('modal-product-description').textContent = product.description;
                document.getElementById('modal-quantity').value = 1;
                
                openProductModal();
            }
        }

        // Add to cart
        function addToCart(productId, quantity = 1) {
            const product = productsData.find(p => p.id === productId);
            alert('done');
            if (product) {
                const existingItem = cart.find(item => item.id === productId);
                
                if (existingItem) {
                    existingItem.quantity += quantity;
                } else {
                    cart.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        image: product.image,
                        quantity: quantity
                    });
                }
                
                updateCart();
                showNotification(`${product.name} added to cart!`);
            }
        }
        
        // Add to cart from modal
        function addToCartFromModal() {
            const quantity = parseInt(document.getElementById('modal-quantity').value);
            const productName = document.getElementById('modal-product-name').textContent;
            const product = productsData.find(p => p.name === productName);
            
            if (product) {
                addToCart(product.id, quantity);
                closeProductModal();
            }
        }
        
        // Update cart
        function updateCart() {
            localStorage.setItem('nazleh_cart', JSON.stringify(cart));
            updateCartCount();
            renderCartItems();
            updateEmptyCartVisibility();
        }
        
        // Update cart count
        function updateCartCount() {
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            cartCount.textContent = count;
        }
        
        // Update empty cart visibility
        function updateEmptyCartVisibility() {
            if (cart.length === 0) {
                emptyCart.classList.add('visible');
                document.querySelector('.cart-footer').style.display = 'none';
            } else {
                emptyCart.classList.remove('visible');
                document.querySelector('.cart-footer').style.display = 'block';
            }
        }
        
        // Render cart items
        function renderCartItems() {
            cartItems.innerHTML = '';
            
            if (cart.length === 0) {
                return;
            }
            
            let total = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="cart-item-image">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-details">
                        <h4 class="cart-item-title">${item.name}</h4>
                        <div class="cart-item-price">$${item.price.toFixed(2)}</div>
                        <div class="cart-item-actions">
                            <div class="quantity-controls">
                                <button onclick="updateCartItemQuantity(${item.id}, ${item.quantity - 1})">-</button>
                                <span>${item.quantity}</span>
                                <button onclick="updateCartItemQuantity(${item.id}, ${item.quantity + 1})">+</button>
                            </div>
                            <button class="remove-item" onclick="removeFromCart(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                cartItems.appendChild(cartItem);
            });
            
            document.getElementById('cart-total').textContent = total.toFixed(2);
        }
        
        // Update cart item quantity
        function updateCartItemQuantity(productId, newQuantity) {
            if (newQuantity < 1) {
                removeFromCart(productId);
                return;
            }
            
            const cartItem = cart.find(item => item.id === productId);
            if (cartItem) {
                cartItem.quantity = newQuantity;
                updateCart();
            }
        }
        
        // Remove from cart
        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCart();
        }
        
        // Toggle cart
        function toggleCart() {
            renderCartItems();
            updateEmptyCartVisibility();
            cartOverlay.classList.toggle('active');
            cartSidebar.classList.toggle('active');
        }
        
        // Proceed to checkout
        function proceedToCheckout() {
            if (cart.length === 0) {
                showNotification('Your cart is empty!', 'error');
                return;
            }
            
            showNotification('Proceeding to checkout...');
            // In a real application, this would redirect to a checkout page
        }
        
        // Open product modal
        function openProductModal() {
            modalOverlay.classList.add('active');
            productModal.classList.add('active');
        }
        
        // Close product modal
        function closeProductModal() {
            modalOverlay.classList.remove('active');
            productModal.classList.remove('active');
        }
        
        // Increase quantity in modal
        function increaseQuantity() {
            const quantityInput = document.getElementById('modal-quantity');
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }
        
        // Decrease quantity in modal
        function decreaseQuantity() {
            const quantityInput = document.getElementById('modal-quantity');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        }
        
        // Scroll to section
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                window.scrollTo({
                    top: section.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        }
        
        // Initialize scroll effects
        function initScrollEffects() {
            // Header scroll effect
            window.addEventListener('scroll', function() {
                const header = document.querySelector('.header');
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                // Active nav link based on scroll position
                const sections = document.querySelectorAll('section');
                const navLinks = document.querySelectorAll('.nav-link');
                
                let currentSection = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 100;
                    if (window.scrollY >= sectionTop) {
                        currentSection = section.getAttribute('id');
                    }
                });
                
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${currentSection}`) {
                        link.classList.add('active');
                    }
                });
            });
        }
        
        // Initialize mobile menu
        function initMobileMenu() {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenuToggle.classList.toggle('active');
                navMenu.classList.toggle('active');
            });
            
            // Close mobile menu when clicking on a link
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenuToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });
        }
        
        // Show notification
        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
            `;
            
            // Add styles for notification
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#4cc9f0' : '#ff006e'};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
                z-index: 1100;
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Animate out and remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
        
        // Load more products (simulated)
        function loadMoreProducts() {
            showNotification('Loading more products...');
            // In a real application, this would fetch more products from an API
            setTimeout(() => {
                showNotification('More products loaded!');
            }, 1500);
        }
        
        // Search functionality
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = searchInput.value.toLowerCase();
                const filteredProducts = productsData.filter(product => 
                    product.name.toLowerCase().includes(searchTerm) || 
                    product.category.toLowerCase().includes(searchTerm) ||
                    product.description.toLowerCase().includes(searchTerm)
                );
                
                renderProducts(filteredProducts);
                scrollToSection('products');
                
                if (filteredProducts.length === 0) {
                    showNotification('No products found for your search', 'error');
                }
            }
        });
// دالة للتصفية حسب الفئة
function filterCategories(categorySlug) {
    console.log('جاري تصفية الفئات حسب:', categorySlug);
    
    const allCategories = document.querySelectorAll('.category-card');
    let found = false;
    
    allCategories.forEach(category => {
        const slug = category.getAttribute('data-category');
        console.log('فحص الفئة:', slug, 'مقارنة بـ:', categorySlug);
        
        if (categorySlug === 'all' || slug === categorySlug) {
            category.style.display = 'block';
            found = true;
            console.log('عرض الفئة:', slug);
        } else {
            category.style.display = 'none';
            console.log('إخفاء الفئة:', slug);
        }
    });
    
    if (!found && categorySlug !== 'all') {
        console.log('⚠️ لم يتم العثور على فئة بهذا الاسم:', categorySlug);
        // عرض جميع الفئات إذا لم يتم العثور على الفئة المطلوبة
        filterCategories('all');
    }
    
    // تحديث زر عرض الكل
    const showAllBtn = document.getElementById('show-all-categories');
    if (showAllBtn) {
        showAllBtn.style.display = categorySlug === 'all' ? 'none' : 'block';
    }
}

// كود للتحكم في التصفية
document.addEventListener('DOMContentLoaded', function() {
    console.log('تم تحميل الصفحة، جاري إعداد نظام التصفية...');
    
    // عرض جميع slugs الموجودة للتصحيح
    const allCategories = document.querySelectorAll('.category-card');
    console.log('الفئات الموجودة:');
    allCategories.forEach(category => {
        console.log('-', category.getAttribute('data-category'));
    });

    // زر عرض الكل
    const showAllButton = document.createElement('button');
    showAllButton.id = 'show-all-categories';
    showAllButton.textContent = 'عرض جميع الفئات';
    showAllButton.style.cssText = 'display: none; margin: 20px auto; padding: 12px 25px; background: #6a11cb; color: white; border: none; border-radius: 25px; cursor: pointer; font-weight: bold;';
    showAllButton.onclick = function() { 
        filterCategories('all');
        document.querySelectorAll('.filter-link').forEach(link => {
            link.classList.remove('active');
        });
    };

    // إضافة الزر
    const categoriesSection = document.getElementById('categories');
    if (categoriesSection) {
        categoriesSection.insertBefore(showAllButton, categoriesSection.firstChild);
    }

    // إضافة event listener لجميع الروابط
    const filterLinks = document.querySelectorAll('.filter-link');
    console.log('عدد روابط التصفية:', filterLinks.length);
    
    filterLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categorySlug = this.getAttribute('data-category');
            console.log('تم النقر على رابط التصفية:', categorySlug);
            
            filterLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            filterCategories(categorySlug);
            
            document.getElementById('categories').scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // التحقق من URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const filter = urlParams.get('filter');
    if (filter) {
        console.log('تصفية من URL:', filter);
        filterCategories(filter);
    }
});
    </script>
    
@endsection