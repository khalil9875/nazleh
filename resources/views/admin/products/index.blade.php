@extends('layouts.admin')

@section('title', 'إدارة المنتجات')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-shopping-bag"></i> إدارة المنتجات</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة منتج جديد
        </a>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>صورة المنتج</th>
                            <th>اسم المنتج</th>
                            <th>الشركة</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="company-image" width=100>
                                @else
                                    <div class="image-placeholder">
                                        <i class="fas fa-box"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->description)
                                    <br><small style="color: #6b7280;">{{ Str::limit($product->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($product->company)
                                    <span class="status-badge status-active">
                                        {{ $product->company->name }}
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        بدون شركة
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong style="color: #27ae60;">{{ number_format($product->price, 2) }} ر.س</strong>
                            </td>
                            <td>
                                <span class="status-badge {{ $product->quantity > 0 ? 'status-active' : 'status-inactive' }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $product->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #6b7280;">
                <i class="fas fa-box" style="font-size: 60px; margin-bottom: 20px;"></i>
                <h3>لا توجد منتجات</h3>
                <p>لم يتم إضافة أي منتجات حتى الآن.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> إضافة أول منتج
                </a>
            </div>
        @endif
    </div>
</div>
@endsection