<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        // $products = Product::latest()->paginate(5);
        // dd($shoppers);

        $products = Category::select()
        ->Join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
        ->Join('products', 'sub_categories.id', '=', 'products.sub_category_id')
        ->orderBy('categories.category_name', 'ASC')
        ->paginate(10);

        // dd($products);

        return view('products.index', compact('products'));
    }
    public function create(){

        // dd($categories);
        $categories = Category::all();
        $subCategories = SubCategory::all();
        
        return view('products.create', compact('categories', 'subCategories'));
    }

    public function store(Request $request){

        // dd($request->all());

        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_code' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            // 'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required|in:0,1',
        ]);
        
        Product::create([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'product_image' => $request->product_image,
            'status' => $request->status,
        ]);

        // sweet alert
        toast('Product added!','success');

        // return redirect()->route('users.index')->with('msg', 'User listed successfully');
        return redirect()->back();
    }

    public function edit($id){
        
        $editProduct = Product::where('id', $id)->first();

        

        $categories = Category::all();
        $subCategories = SubCategory::all();
        
        return view('products.edit', compact('editProduct', 'categories', 'subCategories'));
    }

    public function update(Request $request){
        // dd($request->all());
        
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_code' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            // 'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required|in:0,1',
        ]);
        // dd('dada');
        // Category::where('id', $request->id)->first()->update([
        //     'category_name' => $request->category_name,
        // ]);
        Product::where('id', $request->id)->first()->update([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'product_image' => $request->product_image,
            'status' => $request->status,
        ]);
        // dd($user);
        
        // sweet alert
        toast('Data Updated!','success');

        return redirect()->route('product.index');
    }

    public function delete($id){
        // dd($id);
        Product::where('id', $id)->first()->delete();

        // sweet alert
        toast('Product Deleted!','info');

        return redirect()->back();
    }
}
