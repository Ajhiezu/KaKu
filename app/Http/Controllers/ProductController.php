<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('product.product',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('product.form-product',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'barcode' => 'required|string|max:255|unique:products,barcode',
            'name' => 'required|string|max:100',
            'unit' => 'required|in:kg,pcs,liter',
            'stock' => 'required|integer',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $path = $request->file('image')->store('products','public');

        Product::create([
            'image' => $path,
            'barcode' => $request->barcode,
            'name' => $request->name,
            'unit' => $request->unit,
            'stock' => $request->stock,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('products.index')->with('success','Product created successfully');
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
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('product.form-product',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'barcode' => 'required|string|max:255|unique:products,barcode,' . $product->id,
            'name' => 'required|string|max:100',
            'unit' => 'required|in:kg,pcs,liter',
            'stock' => 'required|integer',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if($request->hasFile('image')){
            Storage::disk('public')->delete($product->image);
            $path = $request->file('image')->store('products','public');
            $product->image = $path;
        }

        $product->barcode = $request->barcode;
        $product->name = $request->name;
        $product->unit = $request->unit;
        $product->stock = $request->stock;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->category_id = $request->category_id;
        $product->save();

        return redirect()->route('products.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }
}
