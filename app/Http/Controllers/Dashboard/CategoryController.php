<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_create'])->only(['create','store']);
        $this->middleware(['permission:categories_update'])->only(['edit','update']);
        $this->middleware(['permission:categories_delete'])->only('destroy');
    }
    public function index(){
        $categories = Category::paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }
    public function create(){
        return view('dashboard.categories.create');
    }
    public function store(Request $request){
        $request->validate([
            'cat_name' => 'required|max:40|unique:categories,cat_name',
        ]);
        $user = Category::create([
            'cat_name' => $request->cat_name,
        ]);
        return redirect()->route('categories.index')->with('success', __('site.added_successfully'));
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit',compact('category'));
    }

    public function update(Request $request, $id){
        $category = Category::findOrFail($id);
        $request->validate([
            'cat_name' => 'required|unique:categories,cat_name,'.$id,
        ]);
        $category->update([
            'cat_name' => $request->cat_name,
        ]);
        return redirect()->route('categories.index')->with('success', __('site.updated_successfully'));
    }
    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', __('site.deleted_successfully'));
    }
}

