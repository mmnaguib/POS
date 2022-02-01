<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = order::whereHas('client', function($q) use ($request){
            return $q->where('name', 'like' , '%' . $request->search . '%');
        })->latest()->paginate(5);
    return view('dashboard.orders.index',compact('orders'));

    }
    public function products(order $order){
        $products = $order->products;
        return view('dashboard.orders._products', compact('products','order'));
    }

    public function destroy(order $order){

        foreach($order->products as $product){

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }
        $order->delete();
        return redirect()->route('orders.index')->with('success', __('site.deleted_successfully'));
    }


}
