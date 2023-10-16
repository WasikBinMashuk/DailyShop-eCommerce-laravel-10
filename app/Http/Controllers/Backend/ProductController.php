<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\returnSelf;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $products = Product::with(['category', 'subCategory'])->get();
            return DataTables::of($products)
                ->addColumn('product_image', function (Product $product) {

                    if ($product->product_image)
                        return '<img src="' . asset('images/' . $product->product_image) . '" style="height: 100px;width:100px;">';
                    else
                        return '<img src="' . asset('images/no.jpg') . '" style="height: 100px; width: 100px;">';
                })
                ->addColumn('category_name', function (Product $product) {
                    return $product->category->category_name;
                })
                ->addColumn('sub_category_name', function (Product $product) {
                    return $product->subCategory->sub_category_name;
                })
                ->editColumn('price', function (Product $product) {
                    return '&#2547;' . $product->price;
                })
                ->editColumn('status', function (Product $product) {
                    if ($product->status == 0) {
                        return '<span class="badge bg-red">Inactive</span>';
                    } else {
                        return '<span class="badge bg-green">Active</span>';
                    }
                })
                ->editColumn('trendy', function (Product $product) {
                    if ($product->trendy == 1) {
                        return '<span class="badge bg-cyan">Trendy</span>';
                    }
                })
                ->addColumn('action', function (Product $product) {
                    $actionBtn = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <a href="' . route('product.edit', $product->id) . '" class="btn btn-primary"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></a>
                <a href="' . route('product.delete', $product->id) . '" class="btn btn-danger" onclick="confirmation(event)"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></a>
              </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status', 'product_image', 'trendy', 'price'])
                ->toJson();
        }
        return view('backend.products.index');
    }

    public function create()
    {

        $categories = Category::get();


        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->filled('product_image'));
        // dd($request->product_image);

        if ($request->has('trendy')) {
            $trendy = $request->trendy;
            // dd('trendy');
        } else {
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
        try {
            if ($request->file('product_image')) {
                $imageName = $request->product_code . '-' . time() . '.' . $request->product_image->extension();
                Image::make($request->product_image)->resize(300, 300)->save('images/' . $imageName);
            } else {
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
            toast('Product added!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }

    public function edit($id)
    {

        $editProduct = Product::where('id', $id)->first();
        // dd($editProduct->sub_category_id,$editProduct->category_id);
        // dd($editProduct);

        $categories = Category::all();
        $subCategories = SubCategory::where('category_id', $editProduct->category_id)->get();

        return view('backend.products.edit', compact('editProduct', 'categories', 'subCategories'));
    }

    public function update(Request $request, $id)
    {
        // dd($id);

        if ($request->has('trendy')) {
            $trendy = $request->trendy;
            // dd('trendy');
        } else {
            $trendy = 0;
            // dd(' not trendy');
        }


        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_code' => ['required', 'min:3', 'max:10', Rule::unique('products', 'product_code')->ignore($id)],
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

                if (file_exists(public_path('images') . "/" . $product->product_image)) {

                    // DELETING THE OLD IMAGE FILE
                    @unlink(public_path('images') . "/" . $product->product_image);
                }

                $imageName = $request->product_code . '-' . time() . '.' . $request->product_image->extension();
                Image::make($request->product_image)->resize(300, 300)->save('images/' . $imageName);
            } else {
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
            toast('Data Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('product.index');
    }

    public function delete($id)
    {

        try {
            $products = Product::where('id', $id)->first();

            if (file_exists(public_path('images') . "/" . $products->product_image)) {

                @unlink(public_path('images') . "/" . $products->product_image);
            }

            $products->delete();
            // sweet alert
            toast('Product Deleted!', 'info');
        } catch (Exception $e) {
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }
}
