@extends('layouts.admin')

@section('title', 'منتجات المكياج')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-shopping-bag"></i> منتجات المكياج</h3>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> إضافة منتج جديد
            </a>
        </div>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($makeupProducts->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">لا توجد منتجات مكياج</h4>
                <p class="text-muted">لم يتم إضافة أي منتجات مكياج حتى الآن</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> إضافة أول منتج
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th width="80">الصورة</th>
                            <th>المنتج</th>
                            <th width="120">الشركة</th>
                            <th width="100">النوع</th>
                            <th width="100">السعر</th>
                            <th width="80">المخزون</th>
                            <th width="80">الحالة</th>
                            <th width="120">الألوان</th>
                            <th width="120">التاريخ</th>
                            <th width="120">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($makeupProducts as $product)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('images/products/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="rounded shadow-sm" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong class="d-block text-dark">{{ $product->name }}</strong>
                                        @if($product->description)
                                            <small class="text-muted">{{ Str::limit($product->description, 35) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($product->company)
                                        <span class="badge bg-info text-dark">{{ $product->company->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">غير محدد</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($product->categ == 'makeup') bg-primary
                                        @elseif($product->categ == 'cosmatic') bg-success
                                        @elseif($product->categ == 'skin care') bg-warning text-dark
                                        @else bg-secondary @endif">
                                        {{ $product->categ }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($product->price, 2) }} ر.س</span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($product->quantity > 10) bg-success
                                        @elseif($product->quantity > 0) bg-warning text-dark
                                        @else bg-danger @endif">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($product->status == 'active') bg-success
                                        @else bg-danger @endif">
                                        {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->colors)
                                        <small class="text-muted d-block" style="font-size: 0.8rem; line-height: 1.2;">
                                            {{ Str::limit($product->colors, 20) }}
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted d-block">
                                        {{ $product->created_at->format('d/m/Y') }}
                                    </small>
                                    <small class="text-muted">
                                        {{ $product->created_at->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.makeup-products.edit', $product->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="تعديل المنتج">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.makeup-products.destroy', $product->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="حذف المنتج"
                                                    onclick="return confirm('حذف المنتج؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($makeupProducts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        {{ $makeupProducts->links() }}
                    </nav>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }
    
    .table th {
        background-color: #2c3e50;
        color: white;
        border: none;
        font-weight: 600;
        padding: 12px 10px;
        text-align: center;
    }
    
    .table td {
        padding: 12px 10px;
        vertical-align: middle;
        border-color: #f1f3f4;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,0.02);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.08);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    .badge {
        font-size: 0.75em;
        font-weight: 500;
        padding: 0.4em 0.6em;
    }
    
    .btn {
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-sm {
        padding: 0.35rem 0.65rem;
        font-size: 0.8rem;
    }
    
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        transform: translateY(-2px);
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
    }
    
    .alert {
        border-radius: 8px;
        border: none;
        margin-bottom: 1.5rem;
    }
    
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 3px;
        border: 1px solid #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #667eea;
        border-color: #667eea;
    }
</style>
@endsection