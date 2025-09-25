<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view("admin.categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("admin.categories.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id',
            'image_url' => 'nullable|url',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::slug($request->name);
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->image_url = $request->image_url;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where("id", "!=", $category->id)->get();
        return view("admin.categories.edit", compact("category", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id',
            'image_url' => 'nullable|url',
        ]);

        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::slug($request->name);
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->image_url = $request->image_url;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route("admin.categories.index")->with("success", "Category deleted successfully.");
    }
}
