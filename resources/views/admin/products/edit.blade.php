@extends('layouts.admin')

@section('title', 'تعديل منتج')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-edit"></i> تعديل منتج: {{ $product->name }}</h3>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-right"></i> العودة إلى القائمة
        </a>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- المعلومات الأساسية -->
            <div class="section-header" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <h4 style="margin: 0; color: #2c3e50;">
                    <i class="fas fa-info-circle"></i> المعلومات الأساسية
                </h4>
            </div>
            
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="fas fa-signature"></i> اسم المنتج
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $product->name) }}" 
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
                          placeholder="أدخل وصف المنتج">{{ old('description', $product->description) }}</textarea>
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
                        <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
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
                               value="{{ old('price', $product->price) }}" 
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
                               value="{{ old('quantity', $product->quantity) }}" 
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
                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
                @error('status')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- الصور -->
            <div class="section-header" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 30px 0 20px;">
                <h4 style="margin: 0; color: #2c3e50;">
                    <i class="fas fa-images"></i> إدارة الصور
                </h4>
            </div>

            <!-- الصورة الرئيسية -->
            <div class="form-group">
                <label class="form-label">الصورة الرئيسية الحالية:</label>
                <div>
                    @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="product-image"
                             style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
                    @else
                        <div class="image-placeholder" style="width: 150px; height: 150px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                            <i class="fas fa-box" style="font-size: 40px; color: #ddd;"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">
                    <i class="fas fa-image"></i> تغيير الصورة الرئيسية (اختياري)
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
            </div>

            <!-- الصور الإضافية -->
            <div class="form-group">
                <label for="additional_images" class="form-label">
                    <i class="fas fa-images"></i> الصور الإضافية (يمكن اختيار أكثر من صورة)
                </label>
                <input type="file" 
                       name="additional_images[]" 
                       id="additional_images" 
                       class="form-control @error('additional_images') is-invalid @enderror" 
                       accept="image/*" 
                       multiple>
                @error('additional_images')
                    <div class="invalid-feedback" style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small style="color: #6b7280; margin-top: 5px; display: block;">
                    <i class="fas fa-info-circle"></i> يمكن اختيار أكثر من صورة باستخدام Ctrl+Click
                </small>
            </div>

            <!-- معاينة الصور الإضافية -->
            <div class="form-group" id="additionalImagesPreview" style="display: none;">
                <label class="form-label">معاينة الصور الإضافية:</label>
                <div id="additionalPreviewContainer" class="row" style="margin-top: 10px;"></div>
            </div>

            <!-- الألوان -->
            <div class="section-header" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 30px 0 20px;">
                <h4 style="margin: 0; color: #2c3e50;">
                    <i class="fas fa-palette"></i> إدارة الألوان
                </h4>
            </div>

            <div class="form-group">
                <label for="colors" class="form-label">
                    <i class="fas fa-tags"></i> الألوان المتاحة
                </label>
                <div>
                    @php
                        $currentColors = old('colors', $product->colors ? json_decode($product->colors, true) : []);
                    @endphp
                    
                    @foreach(['أحمر' => '#dc2626', 'أزرق' => '#2563eb', 'أخضر' => '#16a34a', 'أسود' => '#000000', 'أبيض' => '#ffffff', 'رمادي' => '#6b7280', 'أصفر' => '#eab308', 'بنفسجي' => '#7c3aed'] as $colorName => $colorCode)
                        <div class="form-check form-check-inline" style="margin-right: 15px;">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="colors[]" 
                                   id="color_{{ $loop->index }}" 
                                   value="{{ $colorName }}"
                                   {{ in_array($colorName, $currentColors) ? 'checked' : '' }}>
                            <label class="form-check-label" for="color_{{ $loop->index }}" style="display: flex; align-items: center;">
                                <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $colorCode }}; border: 1px solid #ddd; margin-left: 5px; border-radius: 3px;"></span>
                                {{ $colorName }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('colors')
                    <div class="text-danger" style="margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- المقاسات -->
            <div class="section-header" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 30px 0 20px;">
                <h4 style="margin: 0; color: #2c3e50;">
                    <i class="fas fa-ruler-combined"></i> إدارة المقاسات
                </h4>
            </div>

            <div class="form-group">
                <label for="sizes" class="form-label">
                    <i class="fas fa-expand"></i> المقاسات المتاحة
                </label>
                <div>
                    @php
                        $currentSizes = old('sizes', $product->sizes ? json_decode($product->sizes, true) : []);
                    @endphp
                    
                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                        <div class="form-check form-check-inline" style="margin-right: 15px;">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="sizes[]" 
                                   id="size_{{ $loop->index }}" 
                                   value="{{ $size }}"
                                   {{ in_array($size, $currentSizes) ? 'checked' : '' }}>
                            <label class="form-check-label" for="size_{{ $loop->index }}">
                                {{ $size }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('sizes')
                    <div class="text-danger" style="margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- معاينة الصورة الرئيسية -->
            <div class="form-group" id="imagePreview" style="display: none;">
                <label class="form-label">معاينة الصورة الرئيسية الجديدة:</label>
                <div>
                    <img id="preview" src="#" alt="معاينة الصورة" 
                         style="max-width: 200px; max-height: 200px; border-radius: 10px; border: 2px solid #e2e8f0; object-fit: cover;">
                </div>
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
                
                <a href="{{ route('admin.products.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // معاينة الصورة الرئيسية قبل الرفع
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

    // معاينة الصور الإضافية قبل الرفع
    document.getElementById('additional_images').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('additionalImagesPreview');
        const additionalPreviewContainer = document.getElementById('additionalPreviewContainer');
        const files = e.target.files;
        
        additionalPreviewContainer.innerHTML = '';
        
        if (files.length > 0) {
            previewContainer.style.display = 'block';
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.innerHTML = `
                        <div style="position: relative;">
                            <img src="${e.target.result}" 
                                 alt="معاينة الصورة ${i+1}" 
                                 style="width: 100%; height: 120px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                            <small style="display: block; text-align: center; margin-top: 5px; color: #6b7280;">
                                الصورة ${i+1}
                            </small>
                        </div>
                    `;
                    additionalPreviewContainer.appendChild(col);
                }
                
                reader.readAsDataURL(file);
            }
        } else {
            previewContainer.style.display = 'none';
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
    .col-md-3 {
        flex: 0 0 25%;
        padding: 0 10px;
    }
    .section-header {
        border-right: 4px solid #3b82f6;
    }
    .form-check-inline {
        margin-bottom: 10px;
    }
    @media (max-width: 768px) {
        .col-md-6, .col-md-3 {
            flex: 0 0 100%;
        }
    }
</style>
@endsection