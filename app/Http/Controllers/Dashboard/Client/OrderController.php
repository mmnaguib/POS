<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Category;
use App\Models\order;
use App\Models\Product;

class OrderController extends Controller
{
    public function create(Client $client)
    {
        $orders = $client->orders()->with('products')->paginate(5);
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create', compact('client', 'categories','orders'));
    }
    public function store(Request $request, Client $client)
    {
        $request->validate([
            'products'   => 'required|array',
        ]);
        $this->attach_order($request, $client);
        return redirect()->route('orders.index')->with('success', __('site.added_successfully'));
    }

    public function edit(Client $client, order $order)
    {
        $orders = $client->orders()->with('products')->paginate(5);
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.edit', compact('client', 'order','categories','orders'));
    }
    public function update(Request $request, Client $client, order $order)
    {
        $request->validate([
            'products'   => 'required|array',
        ]);
        $this->detach_order($order);
        $this->attach_order($request, $client);
        return redirect()->route('orders.index')->with('success', __('site.updated_successfully'));
    }
    public function destroy($id)
    {
        //
    }

    private function attach_order($request, $client){
        $order = $client->Orders()->create([]);
        $order->products()->attach($request->products);
        $total_price = 0;
        foreach ($request->products as $id => $quantity) {
            $product = Product::findOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];
            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);
        }
        $order->update([
            'total_price' => $total_price
        ]);

    }
    private function detach_order($order){
        foreach($order->products as $product){

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }
        $order->delete();
    }
}
