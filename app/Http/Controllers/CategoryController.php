<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request){
        // $categories = Category::all();
        // $subCategories = SubCategory::where('category_id', $request->category_id)->get();
        $subCategories = Category::select('categories.id', 'categories.category_name', 'sub_categories.sub_category_name')
        ->Join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
        ->get();
        // dd($subCategories);

        return view('categories.categories', compact('subCategories'));
    }

    public function createCat(){
        return view('categories.createCategory');
    }

    public function createSubCat(){
        $categories = Category::all();

        // dd($categories);
        return view('categories.subCategoryCreate', compact('categories'));
    }

    public function store(Request $request){
        // dd($request->all());

        $request->validate([
            'category_name' => 'required|unique:categories',
        ]);
        
        Category::create([
            'category_name' => $request->category_name,
        ]);

        // sweet alert
        toast('Category added!','success');

        // return redirect()->route('users.index')->with('msg', 'User listed successfully');
        return redirect()->back();
    }

    public function storeSubCat(Request $request){
        // dd($request->all());

        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required',
        ]);
        
        SubCategory::create([
            'category_id' => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
        ]);

        // sweet alert
        toast('Sub Category added!','success');

        // return redirect()->route('users.index')->with('msg', 'User listed successfully');
        return redirect()->back();
    }

    public function edit($id){
        $editCategory = Category::select('categories.id', 'categories.category_name', 'sub_categories.sub_category_name')
        ->Join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
        ->where('categories.id', $id)
        ->first();
        // dd($editCategory);

        // $editshoppers = Shopper::all()->find($id);
        // dd($editShoppers);
        return view('categories.editCategory', compact('editCategory'));
    }

    public function update(Request $request){
        // dd($request->all());
        
        $request->validate([
            'category_name' => 'required',
            'sub_category_name' => 'required',
        ]);
        // dd('dada');
        Category::where('id', $request->id)->first()->update([
            'category_name' => $request->category_name,
        ]);
        SubCategory::where('category_id', $request->id)->first()->update([
            'sub_category_name' => $request->sub_category_name,
        ]);
        // dd($user);
        // $Category->update([
        //     'category_name' => $request->category_name,
        // ]);

        // Shopper->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'address' => $request->address,
        //     'mobile' => $request->mobile
        // ]);

        // sweet alert
        toast('Data Updated!','success');

        return redirect()->route('category.index');
    }

}
