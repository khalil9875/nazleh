@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="css/myul.css">

<!-- Header Section (نفس تنسيق welcome) -->
<section class="hero-section" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white; padding: 80px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 20px;">{{ $category->name }}</h1>
        <p style="font-size: 1.2rem; max-width: 600px; margin: 0 auto;">{{ $category->description ?: 'Explore our premium products in this category' }}</p>
    </div>
</section>

<!-- Products Section (بنفس تنسيق صفحة welcome) -->
<section id="products" class="products" style="padding: 60px 0; background: #f8f9fa; font-family: 'Tajawal', sans-serif;">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 32px; font-weight: 700; color: #2c3e50;">Products in {{ $category->name }}</h2>
            <p style="font-size: 16px; color: #6b7280;">Discover our handpicked selection of premium items</p>
        </div>

        @if($products->count() > 0)
        <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
            @foreach($products as $product)
            <div class="card" style="padding: 25px; border-radius: 15px; background: white; box-shadow: 0 8px 25px rgba(0,0,0,0.06); transition: transform 0.3s ease;">
                <div style="text-align: center;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                             style="width: 140px; height: 140px; object-fit: cover; border-radius: 12px; border: 2px solid #e2e8f0;">
                    @else
                        <div class="image-placeholder" style="width: 140px; height: 140px; background: #f0f0f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-image" style="font-size: 40px; color: #ccc;"></i>
                        </div>
                    @endif
                </div>

                <h4 style="margin-top: 20px; font-size: 20px; font-weight: 600; color: #2c3e50;">{{ $product->name }}</h4>
                <p style="color: #6b7280; font-size: 15px;">{{ Str::limit($product->description, 100) }}</p>
                <p style="margin-top: 10px;"><strong>السعر:</strong> {{ number_format($product->price, 2) }} ر.س</p>
                <p><strong>المخزون:</strong> {{ $product->stock }} قطعة</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-top: 15px;">
                    @csrf
                    <div class="form-group">
                        <label for="quantity_{{ $product->id }}" class="form-label" style="font-weight: 600; color: #2c3e50;">الكمية المطلوبة:</label>
                        <input type="number" name="quantity" id="quantity_{{ $product->id }}"
                               class="form-control" value="1" min="1" max="{{ $product->stock }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="submit" class="btn btn-success" style="flex: 1; padding: 10px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            <i class="fas fa-cart-plus"></i> أضف إلى السلة
                        </button>

                        <a href="#" class="btn" style="
                            flex: 1;
                            background: linear-gradient(135deg, #ff6b81 0%, #e74c3c 100%);
                            color: white;
                            font-weight: 600;
                            text-decoration: none;
                            border-radius: 5px;
                            text-align: center;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            gap: 8px;
                            padding: 10px;
                            transition: all 0.3s ease;
                        " onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fas fa-heart"></i> أضف إلى المفضلة
                        </a>
                    </div>
                </form>
            </div>
            @endforeach
        </div>

        <div class="pagination" style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $products->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 40px;">
            <i class="fas fa-box-open" style="font-size: 60px; color: #ddd;"></i>
            <h3 style="margin-top: 20px; color: #6b7280;">No products found in this category</h3>
            <a href="{{ url('/') }}" class="btn" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #6a11cb; color: white; text-decoration: none; border-radius: 5px;">
                Back to Home
            </a>
        </div>
        @endif
    </div>
</section>

<!-- باقي الأقسام من صفحة welcome إذا أردت -->
<section id="about" class="about">
    <!-- نفس محتوى قسم about من welcome -->
</section>

<section id="contact" class="contact">
    <!-- نفس محتوى قسم contact من welcome -->
</section>
@endsection

@section('scripts')
<script>
// يمكنك إضافة أي scripts إضافية تحتاجها لهذه الصفحة
document.addEventListener('DOMContentLoaded', function() {
    console.log('Category products page loaded');
});
</script>
@endsection