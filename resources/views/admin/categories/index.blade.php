@extends('layouts.admin')

@section('title', 'إدارة الأصناف')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-layer-group me-2"></i>إدارة الأصناف</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>إضافة صنف جديد
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>اسم الصنف</th>
                        <th>الوصف</th>
                        <th>التصنيف الأب</th>
                        <th>الحالة</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if($category->image_url)
                                <img src="{{ Storage::url($category->image_url) }}" alt="{{ $category->name }}" class="category-image">
                            @else
                                <div class="image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $category->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $category->slug }}</small>
                        </td>
                        <td>
                            @if($category->description)
                                {{ Str::limit($category->description, 50) }}
                            @else
                                <span class="text-muted">لا يوجد وصف</span>
                            @endif
                        </td>
                        <td>
                            @if($category->parent)
                                <span class="badge" style="background: #e2e8f0; color: #475569; padding: 5px 10px; border-radius: 6px;">
                                    {{ $category->parent->name }}
                                </span>
                            @else
                                <span class="badge" style="background: #dbeafe; color: #1e40af; padding: 5px 10px; border-radius: 6px;">
                                    رئيسي
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $category->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="action-buttons" style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا الصنف؟')">
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

        <div class="d-flex justify-content-center mt-4">
            {{-- {{ $categories->links() }} --}}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">لا توجد أصناف حتى الآن</h5>
            <p class="text-muted">ابدأ بإضافة أول صنف إلى متجرك</p>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>إضافة أول صنف
            </a>
        </div>
        @endif
    </div>
</div>
@endsection