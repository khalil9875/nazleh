<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:50'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // التحقق من توفر الكمية
        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة تتجاوز المخزون المتاح'
            ], 400);
        }
        
        // التحقق من صحة المقاس إذا تم اختياره
        if ($request->size && $product->sizes) {
            $availableSizes = json_decode($product->sizes, true) ?? [];
            if (!in_array($request->size, $availableSizes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'المقاس المحدد غير متوفر لهذا المنتج'
                ], 400);
            }
        }
        
        // التحقق من صحة اللون إذا تم اختياره
        if ($request->color && $product->colors) {
            $availableColors = json_decode($product->colors, true) ?? [];
            if (!in_array($request->color, $availableColors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'اللون المحدد غير متوفر لهذا المنتج'
                ], 400);
            }
        }
        
        // التحقق إذا كان المنتج موجود بالفعل في السلة بنفس الخيارات
        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();
        
        if ($existingCartItem) {
            // تحديث الكمية إذا كان المنتج موجود بالفعل
            $newQuantity = $existingCartItem->quantity + $request->quantity;
            
            if ($newQuantity > $product->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'الكمية الإجمالية تتجاوز المخزون المتاح'
                ], 400);
            }
            
            $existingCartItem->update(['quantity' => $newQuantity]);
        } else {
            // إضافة عنصر جديد إلى السلة
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'color' => $request->color,
                'price' => $product->price
            ]);
        }
        
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        
        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج إلى السلة بنجاح',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:50'
        ]);

        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $product = $cart->product;
        
        // التحقق من توفر الكمية
        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة تتجاوز المخزون المتاح'
            ], 400);
        }
        
        // التحقق من صحة المقاس إذا تم تغييره
        if ($request->size && $request->size !== $cart->size && $product->sizes) {
            $availableSizes = json_decode($product->sizes, true) ?? [];
            if (!in_array($request->size, $availableSizes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'المقاس المحدد غير متوفر لهذا المنتج'
                ], 400);
            }
        }
        
        // التحقق من صحة اللون إذا تم تغييره
        if ($request->color && $request->color !== $cart->color && $product->colors) {
            $availableColors = json_decode($product->colors, true) ?? [];
            if (!in_array($request->color, $availableColors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'اللون المحدد غير متوفر لهذا المنتج'
                ], 400);
            }
        }
        
        // التحقق إذا كان هناك عنصر آخر بنفس المنتج والخيارات
        if ($request->size !== $cart->size || $request->color !== $cart->color) {
            $existingCartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->where('size', $request->size)
                ->where('color', $request->color)
                ->where('id', '!=', $cart->id)
                ->first();
            
            if ($existingCartItem) {
                // دمج العناصر إذا كان هناك عنصر بنفس الخيارات
                $newQuantity = $existingCartItem->quantity + $request->quantity;
                
                if ($newQuantity > $product->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'الكمية الإجمالية تتجاوز المخزون المتاح'
                    ], 400);
                }
                
                $existingCartItem->update(['quantity' => $newQuantity]);
                $cart->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'تم تحديث السلة بنجاح'
                ]);
            }
        }
        
        $cart->update([
            'quantity' => $request->quantity,
            'size' => $request->size,
            'color' => $request->color
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث السلة بنجاح'
            ]);
        }
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إزالة المنتج من السلة'
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'تم إزالة المنتج من السلة');
    }

    public function getCartCount()
    {
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        
        return response()->json([
            'cart_count' => $cartCount
        ]);
    }
    
    /**
     * الحصول على خيارات المنتج (الألوان والمقاسات)
     */
    public function getProductOptions($productId)
    {
        $product = Product::findOrFail($productId);
        
        $colors = json_decode($product->colors, true) ?? [];
        $sizes = json_decode($product->sizes, true) ?? [];
        
        return response()->json([
            'success' => true,
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }
}