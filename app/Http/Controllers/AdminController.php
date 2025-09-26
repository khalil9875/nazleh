<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'categories' => Category::count(),
           // 'active_categories' => Category::where('is_active', true)->count(),
            'main_categories' => Category::whereNull('parent_id')->count(),
            'sub_categories' => Category::whereNotNull('parent_id')->count()
        ];

        $categories = Category::with('parent')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'categories'));
    }
}