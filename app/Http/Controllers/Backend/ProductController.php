<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;


class ProductController extends Controller
{
    public function index(Request $request){

        $products = Product::select('products.*','categories.category_name','sub_categories.sub_category_name')
        ->Join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
        ->Join('categories', 'categories.id', '=', 'sub_categories.category_id');

        $search = null;

        if($request->filled('search'))
        {
            $search = $request->search;
            $products=$products->where('product_name','LIKE',"%$search%")
            ->orWhere('product_code','LIKE',"%$search%");
        }

        $products= $products->orderBy('products.id', 'DESC')->paginate(5);
      
        return view('backend.products.index', compact('products','search'));
    }

    public function create(){

        $categories = Category::get();

        
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request){
        // dd($request->all());
        // dd($request->filled('product_image'));
        // dd($request->product_image);

        if($request->has('trendy')){
            $trendy = $request->trendy;
            // dd('trendy');
        }else{
            $trendy = 0;
            // dd(' not trendy');
        }

        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_code' => 'required|unique:products|min:3|max:10',
            'product_name' => 'required|min:1|max:50',
            // 'price' => 'nullable|required_with:product_name',
            'price' => 'required|integer',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required|in:0,1',
            'description' => 'nullable|max:65530',
            'trendy' => 'in:1',
        ]);
            // dd("validated");
        try{
            if ($request->file('product_image')) {
                $imageName = $request->product_code.'-'.time().'.'.$request->product_image->extension();
                Image::make($request->product_image)->resize(300,300)->save('images/'.$imageName);
            }else{
                $imageName = null;
            }
    
            Product::create([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'product_image' => $imageName,
                'status' => $request->status,
                'description' => $request->description,
                'trendy' => $trendy,
            ]);

            // sweet alert
            toast('Product added!','success');
        }
        catch (Exception $e){
            // dd($e->getMessage());
            toast('Something went wrong','error');
        }

        return redirect()->back();
    }

    public function edit($id){
        
        $editProduct = Product::where('id', $id)->first();
        // dd($editProduct->sub_category_id,$editProduct->category_id);
        // dd($editProduct);

        $categories = Category::all();
        $subCategories = SubCategory::where('category_id', $editProduct->category_id)->get();

        return view('backend.products.edit', compact('editProduct', 'categories', 'subCategories'));
    }

    public function update(Request $request, $id){
        // dd($id);

        if($request->has('trendy')){
            $trendy = $request->trendy;
            // dd('trendy');
        }else{
            $trendy = 0;
            // dd(' not trendy');
        }

        
            $request->validate([
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'product_code' => ['required','min:3','max:10', Rule::unique('products','product_code')->ignore($id)],
                'product_name' => 'required|min:1|max:50',
                'price' => 'required|integer',
                'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'status' => 'required|in:0,1',
                'description' => 'nullable|max:65530',
                'trendy' => 'in:1',
            ]);
    
            try {
            $product = Product::find($id);
    
            if ($request->file('product_image')) {
    
                if (file_exists(public_path('images')."/".$product->product_image)) {
    
                    // DELETING THE OLD IMAGE FILE
                     @unlink(public_path('images' )."/".$product->product_image);
             
                }
    
                $imageName = $request->product_code.'-'.time().'.'.$request->product_image->extension();
                Image::make($request->product_image)->resize(300,300)->save('images/'.$imageName);
            }else{
                $imageName = $product->product_image;
            }
             
            // dd($imageName);
            // $request->product_image->move(public_path('images'), $imageName);

            // 1/0;
           $product->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'product_image' => $imageName,
                'status' => $request->status,
                'description' => $request->description,
                'trendy' => $trendy,
            ]);
    
            // sweet alert
            toast('Data Updated!','success');
        }
        catch (Exception $e){
            // dd($e->getMessage());
            toast('Something went wrong','error');
        }

        return redirect()->route('product.index');
    }

    public function delete($id){
        
        try{
            $products = Product::where('id', $id)->first();

        if (file_exists(public_path('images' )."/".$products->product_image)) {

            @unlink(public_path('images' )."/".$products->product_image);
     
        }

        $products->delete();
        // sweet alert
        toast('Product Deleted!','info');
        }
        catch(Exception $e){
            toast('Something went wrong','error');
        }

        return redirect()->back();
    }
    

    

    
    
}
