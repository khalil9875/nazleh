<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً',
                'login_required' => true
            ], 401);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        $existingFavorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingFavorite) {
            // إزالة من المفضلة
            $existingFavorite->delete();
            $isFavorite = false;
            $message = 'تم إزالة المنتج من المفضلة';
        } else {
            // إضافة إلى المفضلة
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $isFavorite = true;
            $message = 'تم إضافة المنتج إلى المفضلة';
        }

        $favoritesCount = Favorite::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
            'message' => $message,
            'favorites_count' => $favoritesCount
        ]);
    }

    public function check($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => true,
                'is_favorite' => false
            ]);
        }

        $isFavorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite
        ]);
    }

    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id !== Auth::id()) {
            abort(403);
        }

        $favorite->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إزالة المنتج من المفضلة'
            ]);
        }

        return redirect()->route('favorites.index')
            ->with('success', 'تم إزالة المنتج من المفضلة');
    }

    public function getFavoritesCount()
    {
        if (!Auth::check()) {
            return response()->json([
                'favorites_count' => 0
            ]);
        }

        $count = Favorite::where('user_id', Auth::id())->count();

        return response()->json([
            'favorites_count' => $count
        ]);
    }
}