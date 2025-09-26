<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // عرض جميع الأصناف
    public function index()
    {
        $categories = Category::with('parent')->get();
        $parentCategories = Category::whereNull('parent_id')->get();
        
        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    // عرض نموذج إضافة صنف جديد
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    // حفظ الصنف الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image_url = $imagePath;
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إضافة الصنف بنجاح');
    }

    // عرض نموذج تعديل صنف
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    // تحديث الصنف
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($category->image_url) {
                Storage::disk('public')->delete($category->image_url);
            }

            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image_url = $imagePath;
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث الصنف بنجاح');
    }

    // حذف صنف
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // حذف الصورة إذا كانت موجودة
        if ($category->image_url) {
            Storage::disk('public')->delete($category->image_url);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم حذف الصنف بنجاح');
    }
}
