<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
private function ensureDirectoryExists()
{
    $directories = [
        public_path('images/products'),
        public_path('images/products/additional')
    ];
    
    foreach ($directories as $directory) {
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }
}

    public function index()
    {
        $products = Product::with('company')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.products.create', compact('companies'));
    }

public function store(Request $request)
{
    try {
        \Log::info('بدء عملية إضافة منتج جديد', ['request_data' => $request->all()]);
        
        $this->ensureDirectoryExists();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'company_id' => 'required|exists:companies,id',
            'colors' => 'nullable|array',
            'colors.*' => 'string|max:50',
            'sizes' => 'nullable|array',
            'sizes.*' => 'string|max:20',
        ]);

        \Log::info('التحقق من الصلاحية تم بنجاح');

        // الحصول على بيانات الشركة للتحقق من الاسم
        $company = \App\Models\Company::find($request->company_id);
        \Log::info('بيانات الشركة', ['company' => $company]);
        
        if (!$company) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'الشركة غير موجودة');
        }

        $isMakeupCompany = str_contains(strtolower($company->name), 'makeup 666');
        $isNazlehCloset = str_contains(strtolower($company->name), 'nazleh closet');
        
        \Log::info('نتيجة التحقق من الشركة', [
            'isMakeupCompany' => $isMakeupCompany,
            'isNazlehCloset' => $isNazlehCloset,
            'company_name' => $company->name
        ]);

        // إذا كانت شركة makeup وكان categ مفقوداً
        if ($isMakeupCompany && !$request->has('categ')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'حقل التصنيف مطلوب لمنتجات التجميل');
        }

        // معالجة الصورة الرئيسية (مطلوبة للجميع)
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            \Log::info('تم حفظ الصورة الرئيسية', ['image_name' => $imageName]);
        }

        // معالجة الصور الإضافية - فقط لشركة nazleh closet
        $additionalImages = [];
        if ($isNazlehCloset && $request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $additionalImage) {
                $additionalImageName = time() . '_' . uniqid() . '_additional.' . $additionalImage->getClientOriginalExtension();
                $additionalImage->move(public_path('images/products/additional'), $additionalImageName);
                $additionalImages[] = $additionalImageName;
            }
            \Log::info('تم حفظ الصور الإضافية', ['additional_images' => $additionalImages]);
        }

        // تحويل البيانات إلى JSON - فقط لشركة nazleh closet
        $colors = $isNazlehCloset && $request->has('colors') ? json_encode($request->colors) : null;
        $sizes = $isNazlehCloset && $request->has('sizes') ? json_encode($request->sizes) : null;
        $additionalImagesJson = $isNazlehCloset && !empty($additionalImages) ? json_encode($additionalImages) : null;

        \Log::info('بيانات قبل الحفظ', [
            'isMakeupCompany' => $isMakeupCompany,
            'colors' => $colors,
            'sizes' => $sizes,
            'additional_images' => $additionalImagesJson
        ]);

        // إذا كانت شركة makeup 666، نضيف المنتج إلى جدول makeup_product فقط
        if ($isMakeupCompany) {
            \Log::info('محاولة الإضافة إلى makeup_product');
            $makeupProduct = \App\Models\MakeupProduct::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imageName,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'company_id' => $request->company_id,
                'categ' => $request->categ
            ]);
            \Log::info('تم الإضافة إلى makeup_product بنجاح', ['product_id' => $makeupProduct->id]);
        } else {
            // إذا لم تكن شركة makeup، نضيف إلى جدول product فقط
            \Log::info('محاولة الإضافة إلى product');
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imageName,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'company_id' => $request->company_id,
                'colors' => $colors,
                'sizes' => $sizes,
                'additional_images' => $additionalImagesJson
            ]);
            \Log::info('تم الإضافة إلى product بنجاح', ['product_id' => $product->id]);
        }

        $message = 'تم إنشاء المنتج بنجاح';
        if ($isMakeupCompany) {
            $message .= ' وإضافته إلى منتجات التجميل';
        }
        if ($isNazlehCloset) {
            $message .= ' مع إضافة الألوان والقياسات والصور الإضافية';
        }

        \Log::info('عملية الإضافة تمت بنجاح', ['message' => $message]);
        
        return redirect()->route('admin.products.index')->with('success', $message);

    } catch (\Exception $e) {
        \Log::error('خطأ في إضافة المنتج: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ أثناء إضافة المنتج: ' . $e->getMessage());
    }
}
    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('admin.products.edit', compact('product', 'companies'));
    }

   public function update(Request $request, Product $product)
{
    $this->ensureDirectoryExists();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'status' => 'required|in:active,inactive',
        'company_id' => 'required|exists:companies,id',
        'colors' => 'nullable|array',
        'colors.*' => 'string|max:50',
        'sizes' => 'nullable|array',
        'sizes.*' => 'string|max:20'
    ]);

    $imageName = $product->image;
    
    // تحديث الصورة الرئيسية
    if ($request->hasFile('image')) {
        // حذف الصورة القديمة
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            File::delete(public_path('images/products/' . $product->image));
        }
        
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $imageName);
    }

    // معالجة الصور الإضافية
    $additionalImages = $product->additional_images ? json_decode($product->additional_images, true) : [];
    
    if ($request->hasFile('additional_images')) {
        // حذف الصور الإضافية القديمة إذا رغب المستخدم
        if ($product->additional_images) {
            $oldAdditionalImages = json_decode($product->additional_images, true);
            foreach ($oldAdditionalImages as $oldImage) {
                if (file_exists(public_path('images/products/additional/' . $oldImage))) {
                    File::delete(public_path('images/products/additional/' . $oldImage));
                }
            }
        }
        
        $additionalImages = [];
        foreach ($request->file('additional_images') as $additionalImage) {
            $additionalImageName = time() . '_' . uniqid() . '_additional.' . $additionalImage->getClientOriginalExtension();
            $additionalImage->move(public_path('images/products/additional'), $additionalImageName);
            $additionalImages[] = $additionalImageName;
        }
    }

    // تحويل الألوان والمقاسات إلى JSON
    $colors = $request->has('colors') ? json_encode($request->colors) : null;
    $sizes = $request->has('sizes') ? json_encode($request->sizes) : null;
    $additionalImagesJson = !empty($additionalImages) ? json_encode($additionalImages) : null;

    $product->update([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $imageName,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'status' => $request->status,
        'company_id' => $request->company_id,
        'colors' => $colors,
        'sizes' => $sizes,
        'additional_images' => $additionalImagesJson
    ]);

    return redirect()->route('admin.products.index')
        ->with('success', 'تم تحديث المنتج بنجاح');
}

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            File::delete(public_path('images/products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
    public function makeupIndex()
{
    $makeupProducts = \App\Models\MakeupProduct::with('company')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return view('admin.makeup-products.index', compact('makeupProducts'));
}
public function makeupEdit($id)
{
    $product = \App\Models\MakeupProduct::findOrFail($id);
    $companies = \App\Models\Company::all();
    
    return view('admin.makeup-products.edit', compact('product', 'companies'));
}

public function makeupUpdate(Request $request, $id)
{
    try {
        $product = \App\Models\MakeupProduct::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'categ' => 'required|in:cosmatic,skin care,makeup',
            'colors' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // تحديث الصورة الرئيسية إذا تم رفع جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $product->image = $imageName;
        }

        // تحديث الصور الإضافية إذا تم رفع جديدة
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            // حذف الصور الإضافية القديمة إذا كانت موجودة
            if ($product->additional_images) {
                $oldImages = json_decode($product->additional_images);
                foreach ($oldImages as $oldImage) {
                    if (file_exists(public_path('images/products/additional/' . $oldImage))) {
                        unlink(public_path('images/products/additional/' . $oldImage));
                    }
                }
            }
            
            foreach ($request->file('additional_images') as $additionalImage) {
                $additionalImageName = time() . '_' . uniqid() . '_additional.' . $additionalImage->getClientOriginalExtension();
                $additionalImage->move(public_path('images/products/additional'), $additionalImageName);
                $additionalImages[] = $additionalImageName;
            }
            $product->additional_images = !empty($additionalImages) ? json_encode($additionalImages) : null;
        }

        // تحديث البيانات
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'categ' => $request->categ,
            'colors' => $request->colors ? trim($request->colors) : null,
        ]);

        return redirect()->route('admin.makeup-products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
    }
}
}