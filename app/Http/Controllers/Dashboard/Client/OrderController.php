<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request) {

    }
    public function create(Client $client) {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create', compact('client','categories'));
    }
    public function store(Request $request) {

    }
    public function edit($id) {

    }
    public function update(Request $request, $id) {

    }
    public function destroy($id) {

    }
}
