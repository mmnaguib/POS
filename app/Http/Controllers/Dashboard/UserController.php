<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class UserController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only(['create','store']);
        $this->middleware(['permission:users_update'])->only(['edit','update']);
        $this->middleware(['permission:users_delete'])->only('destroy');
    }
    public function index(Request $request){
        $users = User::whereRoleIs('admin')->when($request->search, function ($query) use ($request){
            return $query->where('first_name', 'like' , '%' . $request->search . '%')
            ->orwhere('last_name', 'like' , '%' . $request->search . '%');
        })->latest()->paginate(5);

        return view('dashboard.users.index',compact('users'));
    }
    public function create(){
        return view('dashboard.users.create');
    }
    public function store(Request $request){
        $request->validate([
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'image' => 'image',
            'permission' => 'required|min:1'
        ]);
        if($request->image){
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/'. $request->image->hashName()));
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_image' => $request->image->hashName()
        ]);
        $user->attachRole('admin');
        $user->syncPermissions($request->permission);
        return redirect()->route('users.index')->with('success', __('site.added_successfully'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.edit',compact('user'));
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $request->validate([
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'email' => 'required|unique:users,email,'.$id,
            'image' => 'image',
            'permission' => 'required|min:1'
        ]);
        if($request->image){
            if($user->user_image){
                Storage::disk('public_images')->delete($user->user_image);
            }
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/'. $request->image->hashName()));
        }
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'user_image' =>$request->image->hashName()
        ]);
        $user->syncPermissions($request->permission);
        return redirect()->route('users.index')->with('success', __('site.updated_successfully'));
    }
    public function destroy($id){
        $user = User::findOrFail($id);
        if($user->user_image != 'default.png'){
            Storage::disk('public_images')->delete($user->user_image);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', __('site.deleted_successfully'));
    }
}
