<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::select('products.*','categories.category_name','sub_categories.sub_category_name')
        ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
        ->Join('categories', 'categories.id', '=', 'sub_categories.category_id')
        ->orderBy('products.id', 'DESC')->paginate(5);

        return view('frontend.home',compact('products'));
    }
}
