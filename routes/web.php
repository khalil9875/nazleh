<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompaneyController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\Company;

// الصفحة الرئيسية
Route::get('/', function () {
    $categories = Category::all();
    $products = Product::all();
    
    $companies = Company::all();
    return view('welcome', compact('categories', 'products', 'companies'));
})->name('home');
// صفحة تفاصيل منتج المكياج
Route::get('/products/makeup/{id}', [CompaneyController::class, 'makeupProductDetails'])->name('makeup.product.details');
// مسارات المصادقة
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// مسارات الفئات والمنتجات العامة
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/nazleh-closet', [CategoryController::class, 'nazlehCloset'])->name('categories.nazleh');
Route::get('/companies/{company}/products', [CompaneyController::class, 'showProducts'])->name('companies.products');

// مسارات السلة
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

// مسارات تتطلب مصادقة
Route::middleware(['auth'])->group(function () {
    Route::get('/prods/{product}', [App\Http\Controllers\CompaneyController::class, 'showProduct'])->name('prods.show');
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/order/confirmation/{order}', [CheckoutController::class, 'orderConfirmation'])->name('order.confirmation');
});

// مسارات الإدارة (تتطلب مصادقة وصلاحية admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::resource('products', ProductController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('orders', OrderController::class);
    
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
// ✅ مسارات منتجات المكياج - داخل المجموعة الصحيحة
    Route::get('/makeup-products', [ProductController::class, 'makeupIndex'])->name('makeup-products.index');
    Route::get('/makeup-products/{id}/edit', [ProductController::class, 'makeupEdit'])->name('makeup-products.edit');
    Route::put('/makeup-products/{id}', [ProductController::class, 'makeupUpdate'])->name('makeup-products.update');
    Route::delete('/makeup-products/{id}', [ProductController::class, 'makeupDestroy'])->name('makeup-products.destroy');    // مسارات الأصناف
   
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});
// مسارات المفضلة
Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

// مسارات عامة (لا تتطلب auth)
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::get('/favorites/check/{product}', [FavoriteController::class, 'check'])->name('favorites.check');
Route::get('/favorites/count', [FavoriteController::class, 'getFavoritesCount'])->name('favorites.count');
require __DIR__."/admin.php";