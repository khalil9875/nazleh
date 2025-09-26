@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>

    <div class="categories-grid">
        @foreach($categories as $cat)
        <div class="category-card {{ $cat->slug == $category->slug ? 'active' : '' }}">
            <div class="category-image">
                @if($cat->image_url)
                    <img src="{{ Storage::url($cat->image_url) }}" alt="{{ $cat->name }}">
                @else
                    <div class="category-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                @endif
            </div>
            <div class="category-content">
                <h3>{{ $cat->name }}</h3>
                <a href="{{ route('categories.show', $cat->slug) }}" class="category-link">
                    Explore Products <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- عرض المنتجات الخاصة بهذه الفئة -->
    @if(isset($products) && $products->count() > 0)
    <div class="products-section">
        <h2>Products in {{ $category->name }}</h2>
        <div class="products-grid">
            @foreach($products as $product)
            <!-- كود عرض المنتج -->
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection