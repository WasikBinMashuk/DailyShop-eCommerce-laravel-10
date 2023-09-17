<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

     public function __construct()
    {
        // Load your objects
        $shopCategories = Category::all();

        // Make it available to all views by sharing it for the header category dropdown
        view()->share('shopCategories', $shopCategories);
    }


    public function index()
    {
        // $products = Product::select('products.*','categories.category_name','sub_categories.sub_category_name')
        // ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
        // ->Join('categories', 'categories.id', '=', 'sub_categories.category_id')
        // ->orderBy('products.id', 'DESC')->take(7)->get();

        $trendy = Product::where('trendy','1')->get();
        $products = Product::orderBy('id','DESC')->take(7)->get();
        // dd($products);

        return view('frontend.home',compact('products','trendy'));
    }

    public function shop(Request $request)
    {

        $products = Product::select('products.*','categories.category_name','sub_categories.sub_category_name')
        ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
        ->Join('categories', 'categories.id', '=', 'sub_categories.category_id');

        if($request->filled('category_id')){
            $categoryId = $request->category_id;
            $products = $products->where('categories.id',"$categoryId");
        }
        elseif($request->filled('search')){
            $search = $request->search;
            $products= $products->where('categories.category_name','LIKE',"%$search%")
            ->orWhere('product_name','LIKE',"%$search%")
            ->orWhere('sub_categories.sub_category_name','LIKE',"%$search%");
        }

        $products= $products->orderBy('products.id', 'DESC')->paginate(12);

        $categories = Category::all();

        return view('frontend.shop',compact('products','categories'));
    }
    

    public function productShow($id)
    {
        // dd($id);

        $product = Product::select('products.*','categories.category_name','sub_categories.sub_category_name')
        ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
        ->Join('categories', 'categories.id', '=', 'sub_categories.category_id')
        ->where('products.id',$id)
        ->orderBy('products.id', 'DESC')->first();

        $categoryId = $product->category_id;

        $relatedProducts = Product::select('products.*','categories.category_name','sub_categories.sub_category_name')
        ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
        ->Join('categories', 'categories.id', '=', 'sub_categories.category_id')
        ->where('products.category_id',$categoryId)
        ->whereNotIn('products.id', [$id])
        ->orderBy('products.id', 'DESC')->get();

        return view('frontend.product',compact('product','relatedProducts'));
    }


}
