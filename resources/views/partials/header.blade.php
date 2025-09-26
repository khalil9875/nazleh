<link rel="stylesheet" href="css/myul.css">
 <header class="header">
        <ul id="myul">
            <li><img src="images/AE.png" class="language-image" alt="العربية" width="40"></li>
            <li><img src="images/US.png" class="language-image" alt="English" width="40"></li>
            <li><a href="#" title="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#nazleh.jewelry" title="Instagram" target="_blank"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#" title="Youtube" target="_blank"><i class="fab fa-youtube"></i></a></li>
        </ul>
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <img src="images/logon.png" alt="Nazleh Jewelry" width="300" height="150">
                </div>
                
                <nav class="nav-menu" id="nav-menu">
                    <ul>
                        <li><a href="#home" class="nav-link active">Home</a></li>
                    
                        <li><a href="#about" class="nav-link">About</a></li>
                        <li><a href="#contact" class="nav-link">Contact</a></li>
                        
                        @auth
                        <li class="mobile-auth">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                                Logout
                            </a>
                        </li>
                        @endauth
                    </ul>
                </nav>
                
                <div class="nav-actions">
                   
                    @auth
                   <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline" style="color:white;">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary"
                        style="   background: black;"
                        >Register</a>
                    </div>
                    @endauth
                </div>
                
                <div class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
<div class="gallery">
<ul id="ul2">
    @foreach($companies as $company)
    <li>
        <a href="{{ route('companies.products', $company) }}" class="filter-link">
            @if($company->logo)
                <img src="{{ asset('images/companies/' . $company->logo) }}" alt="{{ $company->name }}">
            @else
                <img src="images/placeholder.jpg" alt="{{ $company->name }}">
            @endif
            <span id="s">{{ $company->name }}</span>
        </a>
    </li>
    @endforeach
</ul>
</div>
    </header>
<script>
     // تفعيل القائمة المتنقلة للجوال
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            document.getElementById('nav-menu').classList.toggle('active');
        });
        
     document.addEventListener('DOMContentLoaded', function() {
     const slides = document.querySelectorAll('.slide');
            let currentSlide = 0;
            
            function showSlide(n) {
                slides.forEach(slide => slide.classList.remove('active'));
                currentSlide = (n + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
            }
            
            function nextSlide() {
                showSlide(currentSlide + 1);
            }
            
            // تبديل الشرائح كل 3 ثواني
            setInterval(nextSlide, 3000);
        });
</script>
<script>
    // دالة التصفية حسب الفئة
function filterCategoriesBySlug(categorySlug) {
    console.log('Filtering categories by slug:', categorySlug);
    
    // الانتقال إلى صفحة الفئات إذا لم نكن فيها
    if (!window.location.href.includes('categories')) {
        window.location.href = "{{ url('/#categories') }}";
        // تخزين الفئة المطلوبة للتصفية بعد التحميل
        localStorage.setItem('filterCategory', categorySlug);
        return;
    }
    
    const categoryCards = document.querySelectorAll('.category-card');
    let found = false;
    
    categoryCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        console.log('Card category:', cardCategory);
        
        if (categorySlug === 'all' || cardCategory === categorySlug) {
            card.style.display = 'block';
            found = true;
        } else {
            card.style.display = 'none';
        }
    });
    
    if (!found && categorySlug !== 'all') {
        console.log('No categories found with slug:', categorySlug);
    }
}

// تطبيق التصفية عند النقر على الروابط
document.addEventListener('DOMContentLoaded', function() {
    // تطبيق التصفية المخزنة إذا existed
    const savedFilter = localStorage.getItem('filterCategory');
    if (savedFilter) {
        filterCategoriesBySlug(savedFilter);
        localStorage.removeItem('filterCategory');
    }
    
    // إضافة event listener لجميع الروابط التي تحتوي على data-category
    const categoryLinks = document.querySelectorAll('a[data-category]');
    
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categorySlug = this.getAttribute('data-category');
            filterCategoriesBySlug(categorySlug);
        });
    });
});
</script>