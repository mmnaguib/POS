<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ClientController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:clients_read'])->only('index');
        $this->middleware(['permission:clients_create'])->only(['create','store']);
        $this->middleware(['permission:clients_update'])->only(['edit','update']);
        $this->middleware(['permission:clients_delete'])->only('destroy');
    }
    public function index(Request $request){
        $clients = Client::where(function($q) use ($request){
            return $q->when($request->search,function ($query) use ($request){
                return $query->where('name', 'like' , '%' . $request->search . '%')
                ->orwhere('phone', 'like' , '%' . $request->search . '%')
                ->orwhere('address', 'like' , '%' . $request->search . '%');
            });
        })->latest()->paginate(5);

        return view('dashboard.clients.index',compact('clients'));
    }
    public function create(){
        return view('dashboard.clients.create');
    }
    public function store(Request $request){
        $request->validate([
            'client_name' => 'required|max:40',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required'
        ]);
        /*if($request->image){
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/Clients'. $request->image->hashName()));
        }*/
        $client = client::create([
            'name' => $request->client_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect()->route('clients.index')->with('success', __('site.added_successfully'));
    }
    public function edit($id)
    {
        $client = client::findOrFail($id);
        return view('dashboard.clients.edit',compact('client'));
    }

    public function update(Request $request, $id){
        $client = Client::findOrFail($id);
        $request->validate([
            'client_name' => 'required|max:40',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required'
        ]);
        /*if($request->image){
            if($client->client_image){
                Storage::disk('public_images')->delete('/Clients/' . $client->client_image);
            }
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/'. $request->image->hashName()));
        }*/
        $client->update([
            'name' => $request->client_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect()->route('clients.index')->with('success', __('site.updated_successfully'));
    }
    public function destroy($id){
        $client = client::findOrFail($id);
        /*if($client->client_image != 'default.png'){
            Storage::disk('public_images')->delete('/Clients/' . $client->client_image);
        }*/
        $client->delete();
        return redirect()->route('clients.index')->with('success', __('site.deleted_successfully'));
    }
}
