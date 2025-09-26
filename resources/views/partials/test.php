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
        flex: 0 0 calc(33.333% - 30px);
        max-width: calc(33.333% - 30px);
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
        padding: 80px 0;
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

<!-- Hero Slider -->
<div class="hero-slider">
    <div class="slide active">
        <img src="images/22.png" alt="Slide 1">
        <div class="slide-content"></div>
    </div>
    <div class="slide">
        <img src="images/12.png" alt="Slide 2">
        <div class="slide-content"></div>
    </div>
    <div class="slider-nav">
        <div class="slider-dot active" onclick="showSlide(0)"></div>
        <div class="slider-dot" onclick="showSlide(1)"></div>
    </div>
</div>

<!-- Categories Section -->
<section id="categories" class="categories" style="margin-top:400px;">
    <div class="container">
        <div class="section-header">
            <h2>علاماتنا التجارية المميزة</h2>
            <p>اكتشف مجموعتنا المختارة بعناية من خمس شركات متميزة</p>
        </div>
        
        <!-- التصميم المحسن للصور بشكل أفقي -->
        <div class="categories-horizontal">
            <div class="brand-card" data-category="brand1" onclick="filterProducts('Makeup 666')">
                <div class="brand-overlay"></div>
                <div class="brand-image">
                    <img src="images/754f49d3.jpg" alt="العلامة التجارية الأولى">
                </div>
                <div class="brand-content">
                    <h3>ماك اب 666</h3>
                    <p>منتجات تجميل فاخرة وعالية الجودة</p>
                </div>
            </div>
            
            <div class="brand-card" data-category="brand2" onclick="filterProducts('Nazleh Jewellery')">
                <div class="brand-overlay"></div>
                <div class="brand-image">
                    <img src="images/12.png" alt="العلامة التجارية الثانية">
                </div>
                <div class="brand-content">
                    <h3>نظلة للمجوهرات</h3>
                    <p>مجوهرات حصرية من الذهب والماس</p>
                </div>
            </div>
            
            <div class="brand-card" data-category="brand3" onclick="filterProducts('Nazleh Ounce')">
                <div class="brand-overlay"></div>
                <div class="brand-image">
                    <img src="images/22.png" alt="العلامة التجارية الثالثة">
                </div>
                <div class="brand-content">
                    <h3>نظلة للأونصة</h3>
                    <p>ذهب ومعادن ثمينة بدرجة استثمارية</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>عن نظلة</h3>
                <p>نظلة هي وجهتك الأولى للرفاهية والجودة. نقدم مجموعة مختارة بعناية من المنتجات الفاخرة التي تلبي أعلى معايير الجودة.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>روابط سريعة</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-left"></i> الرئيسية</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> المنتجات</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> العلامات التجارية</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> من نحن</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> اتصل بنا</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>علاماتنا التجارية</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-left"></i> ماك اب 666</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> نظلة للمجوهرات</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> نظلة للأونصة</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> نظلة للملابس</a></li>
                    <li><a href="#"><i class="fas fa-chevron-left"></i> الكنز</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>اتصل بنا</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span>الرياض، المملكة العربية السعودية</span>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <span>+966 123 456 789</span>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span>info@nazleh.com</span>
                    </div>
                </div>
                
                <h4 style="margin-top: 20px;">النشرة البريدية</h4>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="بريدك الإلكتروني" required>
                    <button type="submit" class="newsletter-btn">اشتراك</button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2023 نظلة. جميع الحقوق محفوظة. | تصميم وتطوير بواسطة فريق نظلة</p>
        </div>
    </div>
</footer>

<!-- باقي الكود الحالي يبقى كما هو -->

@endsection

@section('modals')
    @include('partials.product-modal')
@endsection

@section('scripts')
    <!-- الكود الحالي للـ scripts يبقى كما هو -->
@endsection