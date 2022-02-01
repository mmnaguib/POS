<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DachboardController extends Controller
{
    public function index() {
        $categories = Category::count();
        $products = Product::count();
        $clients = Client::count();
        $users = User::whereRoleIs('admin')->count();

        $sales_data = order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum')
        )->groupBy('month')->get();

        return view('dashboard.index', compact('categories','products','clients','users','sales_data'));
    }
}
