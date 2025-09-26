@extends('layouts.app')

@section('title', 'المفضلة')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4"><i class="fas fa-heart text-danger"></i> قائمة المفضلة</h1>
        </div>
    </div>

    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/products/' . $favorite->product->image) }}" 
                             class="card-img-top" 
                             alt="{{ $favorite->product->name }}"
                             style="height: 250px; object-fit: cover;">
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $favorite->product->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($favorite->product->description, 100) }}</p>
                            <p class="card-text"><strong>السعر: {{ number_format($favorite->product->price, 2) }} ر.س</strong></p>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('products.show', $favorite->product->id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> عرض المنتج
                                </a>
                                
                                <button class="btn btn-outline-danger wishlist-btn" 
                                        data-product-id="{{ $favorite->product->id }}">
                                    <i class="fas fa-heart"></i> إزالة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-heart-broken fa-3x text-muted mb-3"></i>
            <h3 class="text-muted">لا توجد منتجات في المفضلة</h3>
            <p class="text-muted">ابدأ بإضافة بعض المنتجات إلى قائمة المفضلة الخاصة بك</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> تصفح المنتجات
            </a>
        </div>
    @endif
</div>
<style>
    .wishlist-btn {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.wishlist-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
}

.wishlist-btn:active {
    transform: scale(0.95);
}

.wishlist-btn.loading {
    opacity: 0.7;
    pointer-events: none;
}

.wishlist-btn.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endsection