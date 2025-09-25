@extends('layouts.admin')

@section('title', 'تعديل منتج مكياج')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-edit"></i> تعديل منتج: {{ $product->name }}</h3>
            <a href="{{ route('admin.makeup-products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i> العودة للقائمة
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.makeup-products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">اسم المنتج</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $product->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="company_id" class="form-label">الشركة</label>
                        <select name="company_id" id="company_id" class="form-select" disabled>
                            <option value="{{ $product->company_id }}">{{ $product->company->name }}</option>
                        </select>
                        <small class="text-muted">لا يمكن تغيير الشركة بعد الإنشاء</small>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label">وصف المنتج</label>
                <textarea name="description" 
                          id="description" 
                          class="form-control @error('description') is-invalid @enderror" 
                          rows="3">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="categ" class="form-label">تصنيف المنتج</label>
                        <select name="categ" id="categ" class="form-select @error('categ') is-invalid @enderror" required>
                            <option value="makeup" {{ old('categ', $product->categ) == 'makeup' ? 'selected' : '' }}>Makeup</option>
                            <option value="cosmatic" {{ old('categ', $product->categ) == 'cosmatic' ? 'selected' : '' }}>Cosmatic</option>
                            <option value="skin care" {{ old('categ', $product->categ) == 'skin care' ? 'selected' : '' }}>Skin Care</option>
                        </select>
                        @error('categ')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="price" class="form-label">السعر (ر.س)</label>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               step="0.01" 
                               min="0"
                               class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price', $product->price) }}" 
                               required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="quantity" class="form-label">الكمية</label>
                        <input type="number" 
                               name="quantity" 
                               id="quantity" 
                               min="0"
                               class="form-control @error('quantity') is-invalid @enderror" 
                               value="{{ old('quantity', $product->quantity) }}" 
                               required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

<div class="form-group mb-3">
    <label for="colors" class="form-label">درجات الألوان</label>
    <input type="text" 
           name="colors" 
           id="colors" 
           class="form-control @error('colors') is-invalid @enderror" 
           value="{{ old('colors', $product->colors) }}" 
           placeholder="أدخل درجات الألوان مفصولة بفواصل (مثال: أحمر, وردي, بني)">
    @error('colors')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">حالة المنتج</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="image" class="form-label">صورة المنتج الرئيسية</label>
                <input type="file" 
                       name="image" 
                       id="image" 
                       class="form-control @error('image') is-invalid @enderror" 
                       accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="الصورة الحالية" 
                             style="max-width: 200px; max-height: 200px;" 
                             class="img-thumbnail">
                        <small class="text-muted d-block">الصورة الحالية</small>
                    </div>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="additional_images" class="form-label">الصور الإضافية</label>
                <input type="file" 
                       name="additional_images[]" 
                       id="additional_images" 
                       class="form-control @error('additional_images') is-invalid @enderror" 
                       accept="image/*" 
                       multiple>
                @error('additional_images')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($product->additional_images)
                    <div class="mt-2">
                        @foreach(json_decode($product->additional_images) as $additionalImage)
                            <img src="{{ asset('images/products/additional/' . $additionalImage) }}" 
                                 alt="صورة إضافية" 
                                 style="max-width: 100px; max-height: 100px;" 
                                 class="img-thumbnail me-2 mb-2">
                        @endforeach
                        <small class="text-muted d-block">الصور الإضافية الحالية</small>
                    </div>
                @endif
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
                
                <a href="{{ route('admin.makeup-products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection