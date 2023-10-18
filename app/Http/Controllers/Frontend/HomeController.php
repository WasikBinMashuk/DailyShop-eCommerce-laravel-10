<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $trendy = Product::status('1')->get();
        $sliders = Slider::status('1')->get();
        $products = Product::orderBy('id', 'DESC')->take(7)->get();

        return view('frontend.home', compact('products', 'trendy', 'sliders'));
    }

    public function shop(Request $request)
    {

        $products = Product::select('products.*', 'categories.category_name', 'sub_categories.sub_category_name')
            ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->Join('categories', 'categories.id', '=', 'sub_categories.category_id');

        if ($request->filled('category_id')) {
            $products = $products->where('categories.id',  $request->category_id);
        } elseif ($request->filled('search')) {
            $search = $request->search;
            $products = $products->where('categories.category_name', 'LIKE', "%$search%")
                ->orWhere('product_name', 'LIKE', "%$search%")
                ->orWhere('sub_categories.sub_category_name', 'LIKE', "%$search%");
        }

        $products = $products->orderBy('products.id', 'DESC')->paginate(12);

        $categories = Category::withCount('products')->get();

        return view('frontend.shop', compact('products', 'categories'));
    }

    public function productShow($id)
    {
        $product = Product::select('products.*', 'categories.category_name', 'sub_categories.sub_category_name')
            ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->Join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->where('products.id', $id)
            ->orderBy('products.id', 'DESC')->first();

        $categoryId = $product->category_id;

        $relatedProducts = Product::select('products.*', 'categories.category_name', 'sub_categories.sub_category_name')
            ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->Join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->where('products.category_id', $categoryId)
            ->whereNotIn('products.id', [$id])
            ->orderBy('products.id', 'DESC')->get();

        return view('frontend.product', compact('product', 'relatedProducts'));
    }
}
