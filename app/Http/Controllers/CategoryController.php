<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view("category.category", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.form-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'name' => 'required|string|max:255',
        ]);

        $path = $request->file('image')->store('categories','public');

        Category::create([
            'image' => 'storage/' . $path,
            'name' => $validated['name'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Category successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.form-category',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'name' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){
            Storage::disk('public')->delete(str_replace('storage/','',$category->image));
            $path = $request->file('image')->store('categories','public');
            $category->image = 'storage/' . $path;
        }

        $category->name = $validated['name'];
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Storage::disk('public')->delete(str_replace('storage/','',$category->image));
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category successfully deleted!');
    }
}
