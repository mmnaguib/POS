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
    public function index(Request $request){
        $categories = Category::where(function($q) use ($request){
            return $q->when($request->search,function ($query) use ($request){
                return $query->where('name->ar', 'like' , '%' . $request->search . '%')->orwhere('name->en', 'like' , '%' . $request->search . '%');;
            });
        })->latest()->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }
    public function create(){
        return view('dashboard.categories.create');
    }
    public function store(Request $request){
        $request->validate([
            'ar_name' => 'required|unique:categories,name->ar',
            'en_name' => 'required|unique:categories,name->en',
        ]);
        $category = new Category();
        $category->name = ['ar' => $request->ar_name, 'en' => $request->en_name];
        $category->save();
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
            'ar_name' => 'required|unique:categories,name->ar,'.$id,
            'en_name' => 'required|unique:categories,name->en,'.$id,
        ]);
        $category->name = ['ar' => $request->ar_name, 'en' => $request->en_name];
        $category->save();
        return redirect()->route('categories.index')->with('success', __('site.updated_successfully'));
    }
    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', __('site.deleted_successfully'));
    }
}

