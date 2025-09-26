@extends('layouts.admin')

@section('title', 'تعديل الصنف: ' . $category->name)

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-edit me-2"></i>تعديل الصنف: {{ $category->name }}</h3>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>رجوع
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">اسم الصنف *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $category->name) }}" required 
                               placeholder="أدخل اسم الصنف">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent_id">التصنيف الأب</label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" 
                                id="parent_id" name="parent_id">
                            <option value="">-- اختر التصنيف الأب --</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">الوصف</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4"
                          placeholder="أدخل وصفاً للصنف">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">صورة الصنف</label>
                        
                        @if($category->image_url)
                        <div class="mb-3">
                            <img src="{{ Storage::url($category->image_url) }}" alt="{{ $category->name }}" 
                                 class="category-image" style="width: 100px; height: 100px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                <label class="form-check-label text-danger" for="remove_image">
                                    حذف الصورة الحالية
                                </label>
                            </div>
                        </div>
                        @endif
                        
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">اتركه فارغاً للحفاظ على الصورة الحالية</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="is_active">حالة الصنف</label>
                        <select class="form-select" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', $category->is_active) ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ !old('is_active', $category->is_active) ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>تحديث الصنف
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection