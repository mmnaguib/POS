<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:products_read'])->only('index');
        $this->middleware(['permission:products_create'])->only(['create', 'store']);
        $this->middleware(['permission:products_update'])->only(['edit', 'update']);
        $this->middleware(['permission:products_delete'])->only('destroy');
    }
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = product::when($request->search, function ($query) use ($request) {
                return $query->where('name->ar', 'like', '%' . $request->search . '%')
                ->orwhere('name->en', 'like', '%' . $request->search . '%');
            })->when($request->category_id, function ($q) use ($request) {
                return $q->where('category_id', $request->category_id);
            })->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories','products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category'     => 'required',
            'ar_product_name' => 'required|unique:products,name->ar',
            'en_product_name' => 'required|unique:products,name->en',
            'ar_product_desc' => 'required|unique:products,description->ar',
            'en_product_desc' => 'required|unique:products,description->en',
            'purchase_price'  => 'required',
            'sale_price'      => 'required',
            'stock'           => 'required',
        ]);
        if ($request->image) {
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/products/' . $request->image->hashName()));
        }
        $product = new Product();
        $product->category_id = $request->category;
        $product->name = ['ar' => $request->ar_product_name, 'en' => $request->en_product_name];
        $product->description = ['ar' => $request->ar_product_desc, 'en' => $request->en_product_desc];
        $product->image = $request->image->hashName();
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->save();
        return redirect()->route('products.index')->with('success', __('site.added_successfully'));
    }
    public function edit($id)
    {
        $categories = Category::all();
        $product = product::findOrFail($id);
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category'     => 'required',
            'ar_product_name' => 'required|unique:products,name->ar,'.$id,
            'en_product_name' => 'required|unique:products,name->en,'. $id,
            'ar_product_desc' => 'required|unique:products,description->ar,'. $id,
            'en_product_desc' => 'required|unique:products,description->en,'. $id,
            'purchase_price'  => 'required',
            'sale_price'      => 'required',
            'stock'           => 'required',
        ]);

        $product = product::findOrFail($id);
        if ($request->image) {
            if ($product->image) {
                Storage::disk('public_images')->delete('/products/' . $product->image);
            }
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/products/' . $request->image->hashName()));
        }
        $product->category_id = $request->category;
        $product->name = ['ar' => $request->ar_product_name, 'en' => $request->en_product_name];
        $product->description = ['ar' => $request->ar_product_desc, 'en' => $request->en_product_desc];
        $product->image = $request->image->hashName();
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->save();
        return redirect()->route('products.index')->with('success', __('site.updated_successfully'));
    }
    public function destroy($id)
    {
        $product = product::findOrFail($id);
        if ($product->image != 'default.png') {
            Storage::disk('public_images')->delete('/products/' . $product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', __('site.deleted_successfully'));
    }
}
