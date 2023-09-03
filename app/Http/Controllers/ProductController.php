<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;


class ProductController extends Controller
{
    public function index(){
        // $products = Product::latest()->paginate(5);
        // dd($shoppers);

        // $products = Category::select()
        // ->Join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
        // ->Join('products', 'sub_categories.id', '=', 'products.sub_category_id')
        // ->orderBy('categories.category_name', 'ASC')
        // ->paginate(10);
        $products = Product::select('products.id','products.product_image','categories.category_name','sub_categories.sub_category_name','products.product_code','products.product_name','products.price','products.status')
        ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
        ->Join('categories', 'categories.id', '=', 'sub_categories.category_id')
        ->orderBy('categories.category_name', 'ASC')
        ->paginate(5);

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
        // dd($request->file('product_image'));

        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_code' => 'required|unique:products',
            'product_name' => 'required',
            'price' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required|in:0,1',
        ]);

        if ($request->has('product_image')) {
            $imageName = $request->product_code.'-'.time().'.'.$request->product_image->extension();
            Image::make($request->product_image)->resize(300,300)->save('images/'.$imageName);
        }else{
            $imageName = null;
        }

        
        // dd($imageName);
        // $request->product_image->move(public_path('images'), $imageName);

        // $product_image = $request->file('product_image');
        // dd($product_image);
        
        
        Product::create([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'product_image' => $imageName,
            'status' => $request->status,
        ]);

        // sweet alert
        toast('Product added!','success');

        // return redirect()->route('users.index')->with('msg', 'User listed successfully');
        return redirect()->back();
    }

    public function edit($id){
        
        $editProduct = Product::where('id', $id)->first();
        // dd($editProduct);
        

        $categories = Category::all();
        // $subCategories = SubCategory::all();
        $subCategories = SubCategory::where('category_id', $editProduct->category_id)->get();
        // dd($subCategories);
        
        return view('products.edit', compact('editProduct', 'categories', 'subCategories'));
    }

    public function update(Request $request){
        // dd($request->all());
        
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_code' => ['required', Rule::unique('products','product_code')->ignore($request->id)],
            'product_name' => 'required',
            'price' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required|in:0,1',
        ]);
        

        

        if ($request->has('product_image')) {
            // dd('dada');
            
            // DELETING THE OLD IMAGE FILE
            @unlink(public_path('images' )."/".$request->old_image);

            $imageName = $request->product_code.'-'.time().'.'.$request->product_image->extension();
            Image::make($request->product_image)->resize(300,300)->save('images/'.$imageName);
        }else{
            // dd('noooo');
            $imageName = $request->old_image;
        }

         
        // dd($imageName);
        // $request->product_image->move(public_path('images'), $imageName);
        

        Product::where('id', $request->id)->first()->update([
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'product_image' => $imageName,
            'status' => $request->status,
        ]);
        // dd($user);


        
        // sweet alert
        toast('Data Updated!','success');

        return redirect()->route('product.index');
    }

    public function delete($id){
        // dd($id);
        
        $products = Product::where('id', $id)->first();
        // dd($products);
        // dd(public_path('images' )."/".$products->product_image);

        if (file_exists(public_path('images' )."/".$products->product_image)) {

            @unlink(public_path('images' )."/".$products->product_image);
     
        }

        $products->delete();
        // sweet alert
        toast('Product Deleted!','info');

        return redirect()->back();
    }

    // getting this request from ajax for dependant dropdown menus
    public function getCategory(Request $request){
        $cid = $request->post('cid');

        $subCategories = SubCategory::where('category_id',$cid)->get();
        $html = '<option value="">Select Subcategory</option>';
        foreach($subCategories as $list){
            $html.='<option value="'.$list->id.'">'.$list->sub_category_name.'</option>';
        }
        echo $html;
    }

    
    
}
