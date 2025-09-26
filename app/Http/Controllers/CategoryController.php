<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $categories = Category::with('products')->get();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

public function showProducts($slug)
{
    // العثور على الفئة باستخدام slug
    $category = Category::where('slug', $slug)->firstOrFail();
    
    // جلب المنتجات التابعة لهذه الفئة
    $products = $category->products()->paginate(12);
    
    // جلب جميع الفئات للقائمة الجانبية (إذا needed)
    $categories = Category::all();
    
    return view('category-products', compact('category', 'products', 'categories'));
}
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100|unique:categories',
                'slug' => 'required|string|max:100|unique:categories',
                'description' => 'nullable|string',
                'image_url' => 'nullable|string|max:255'
            ]);

            $category = Category::create($validated);
            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'sometimes|string|max:100|unique:categories,name,' . $id,
                'slug' => 'sometimes|string|max:100|unique:categories,slug,' . $id,
                'description' => 'nullable|string',
                'image_url' => 'nullable|string|max:255'
            ]);

            $category->update($validated);
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
public function show($slug)
    {
        // العثور على الفئة المطلوبة
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // جلب جميع الفئات لعرضها في القائمة
        $categories = Category::all();
        
        // جلب المنتجات الخاصة بهذه الفئة إذا needed
        $products = $category->products; // إذا كان لديك علاقة
        
        return view('categories.show', compact('category', 'categories', 'products'));
    }
    public function destroy($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function nazlehCloset()
{
    $categories = Category::where('slug', 'nazleh closet')->get();
   $products=Product::all();
    
    return view('welcome', compact('categories','products'));
}
}
