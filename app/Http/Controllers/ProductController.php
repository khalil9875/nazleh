<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index()
{
    $products = Product::with('category')->get();
    return view('admin.products.index', compact('products'));
}

public function show(Product $product)
{
    $company = $product->company;
    $companies = Company::all(); // للتنقل بين الشركات
    
    return view('product-details', compact('product', 'company', 'companies'));
}

    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->get('q', '');
            
            $products = Product::with('category')
                ->where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%");
                })
                ->get();
                
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    

    public function destroy($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getComments($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            $comments = $product->comments()->where('is_approved', true)->get();
            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addComment(Request $request, $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            
            $validated = $request->validate([
                'author_name' => 'required|string|max:100',
                'author_email' => 'required|email|max:120',
                'comment_text' => 'required|string',
                'rating' => 'nullable|integer|min:1|max:5'
            ]);

            $validated['product_id'] = $id;
            $comment = ProductComment::create($validated);
            
            return response()->json($comment, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function create()
{
    $categories = Category::all();
    return view('admin.products.create', compact('categories'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:200',
        'slug' => 'required|string|max:200|unique:products',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success', 'تمت إضافة المنتج بنجاح');
}
public function edit(Product $product)
{
    $categories = Category::all();
    return view('admin.products.edit', compact('product', 'categories'));
}

public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:200',
        'slug' => 'required|string|max:200|unique:products,slug,' . $product->id,
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    $product->update($validated);

    return redirect()->route('admin.products.index')->with('success', 'تم تعديل المنتج بنجاح');
}
}
