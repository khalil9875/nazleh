@extends('layouts.admin')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-plus"></i> إضافة منتج جديد</h3>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-right"></i> العودة إلى القائمة
        </a>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="fas fa-signature"></i> اسم المنتج
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" 
                       required 
                       placeholder="أدخل اسم المنتج">
                @error('name')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">
                    <i class="fas fa-align-left"></i> وصف المنتج
                </label>
                <textarea name="description" 
                          id="description" 
                          class="form-control @error('description') is-invalid @enderror" 
                          rows="3" 
                          placeholder="أدخل وصف المنتج">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="company_id" class="form-label">
                    <i class="fas fa-building"></i> الشركة
                </label>
                <select name="company_id" 
                        id="company_id" 
                        class="form-select @error('company_id') is-invalid @enderror" 
                        required>
                    <option value="">اختر الشركة</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" 
                                data-name="{{ $company->name }}"
                                {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- حقل categ المخفي الذي يظهر فقط لشركات makeup 666 -->
            <div class="form-group" id="categField" style="display: none;">
                <label for="categ" class="form-label">
                    <i class="fas fa-tags"></i> تصنيف المنتج
                </label>
                <select name="categ" 
                        id="categ" 
                        class="form-select @error('categ') is-invalid @enderror">
                    <option value="">اختر التصنيف</option>
                    <option value="cosmatic" {{ old('categ') == 'cosmatic' ? 'selected' : '' }}>Cosmatic</option>
                    <option value="skin care" {{ old('categ') == 'skin care' ? 'selected' : '' }}>Skin Care</option>
                    <option value="makeup" {{ old('categ') == 'makeup' ? 'selected' : '' }}>Makeup</option>
                </select>
                @error('categ')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small style="color: #6b7280; margin-top: 5px; display: block;">
                    <i class="fas fa-info-circle"></i> هذا الحقل مطلوب فقط لمنتجات التجميل
                </small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price" class="form-label">
                            <i class="fas fa-tag"></i> السعر (ر.س)
                        </label>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               step="0.01" 
                               min="0"
                               class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price') }}" 
                               required 
                               placeholder="0.00">
                        @error('price')
                            <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantity" class="form-label">
                            <i class="fas fa-cubes"></i> الكمية
                        </label>
                        <input type="number" 
                               name="quantity" 
                               id="quantity" 
                               min="0"
                               class="form-control @error('quantity') is-invalid @enderror" 
                               value="{{ old('quantity', 0) }}" 
                               required>
                        @error('quantity')
                            <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">
                    <i class="fas fa-check-circle"></i> حالة المنتج
                </label>
                <select name="status" 
                        id="status" 
                        class="form-select @error('status') is-invalid @enderror" 
                        required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
                @error('status')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">
                    <i class="fas fa-image"></i> صورة المنتج
                </label>
                <input type="file" 
                       name="image" 
                       id="image" 
                       class="form-control @error('image') is-invalid @enderror" 
                       accept="image/*">
                @error('image')
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
                    <i class="fas fa-save"></i> حفظ المنتج
                </button>
                
                <a href="{{ route('admin.products.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // معاينة الصورة قبل الرفع
    document.getElementById('image').addEventListener('change', function(e) {
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

    // التحكم في إظهار/إخفاء حقل categ بناءً على الشركة المختارة
    document.getElementById('company_id').addEventListener('change', function() {
        const categField = document.getElementById('categField');
        const selectedOption = this.options[this.selectedIndex];
        const companyName = selectedOption.getAttribute('data-name');
        
        // التحقق إذا كان اسم الشركة يحتوي على "makeup 666"
        if (companyName && companyName.includes('makeup 666')) {
            categField.style.display = 'block';
            // جعل الحقل مطلوباً
            document.getElementById('categ').setAttribute('required', 'required');
        } else {
            categField.style.display = 'none';
            // إزالة الخاصية required
            document.getElementById('categ').removeAttribute('required');
            // إعادة تعيين القيمة
            document.getElementById('categ').value = '';
        }
    });

    // تشغيل الحدث عند تحميل الصفحة للتعامل مع القيم القديمة
    document.addEventListener('DOMContentLoaded', function() {
        const companySelect = document.getElementById('company_id');
        if (companySelect.value) {
            companySelect.dispatchEvent(new Event('change'));
        }
        
        // إذا كان هناك قيمة قديمة لـ categ، نظهر الحقل
        const oldCategValue = "{{ old('categ') }}";
        if (oldCategValue) {
            document.getElementById('categField').style.display = 'block';
        }
    });
</script>

<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .col-md-6 {
        flex: 0 0 50%;
        padding: 0 10px;
    }
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
        }
    }
</style>
@endsection