@extends('layouts.admin')

@section('title', 'إضافة شركة جديدة')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-plus"></i> إضافة شركة جديدة</h3>
        <a href="{{ route('admin.companies.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-right"></i> العودة إلى القائمة
        </a>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="fas fa-signature"></i> اسم الشركة
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" 
                       required 
                       placeholder="أدخل اسم الشركة">
                @error('name')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="logo" class="form-label">
                    <i class="fas fa-image"></i> صورة الشركة
                </label>
                <input type="file" 
                       name="logo" 
                       id="logo" 
                       class="form-control @error('logo') is-invalid @enderror" 
                       accept="image/*">
                @error('logo')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small style="color: #6b7280; margin-top: 5px; display: block;">
                    <i class="fas fa-info-circle"></i> الصور المسموحة: JPEG, PNG, JPG, GIF - الحد الأقصى: 2MB
                </small>
            </div>

            <!-- معاينة الصورة -->
            <div class="form-group" id="imagePreview" style="display: none;">
                <label class="form-label">معاينة الصورة:</label>
                <div>
                    <img id="preview" src="#" alt="معاينة الصورة" 
                         style="max-width: 200px; max-height: 200px; border-radius: 10px; border: 2px solid #e2e8f0;">
                </div>
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> حفظ الشركة
                </button>
                
                <a href="{{ route('admin.companies.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // معاينة الصورة قبل الرفع
    document.getElementById('logo').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endsection