<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct()  
    {  
        $this->middleware('auth');  
    }

    public function index(Request $request){
        $subCategories = Category::select('categories.id', 'categories.category_name', 'sub_categories.sub_category_name', 'sub_categories.id', 'sub_categories.category_id')
        ->Join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
        ->orderBy('categories.category_name', 'ASC')
        ->orderBy('sub_categories.sub_category_name', 'ASC')
        ->paginate(10);

        return view('categories.Subcategories', compact('subCategories'));
    }

    public function createSubCat(){
        $categories = Category::all();

        return view('categories.subCategoryCreate', compact('categories'));
    }

    public function storeSubCat(Request $request){

        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required|max:255',
        ]);
        
        SubCategory::create([
            'category_id' => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
        ]);

        // sweet alert
        toast('Sub Category added!','success');

        return redirect()->back();
    }

    public function edit($id){
        $editCategory = SubCategory::where('id', $id)->first();

        $categories = Category::all();

        return view('categories.editSubCategory', compact('editCategory', 'categories'));
    }

    public function update(Request $request){
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required',
        ]);
        
        SubCategory::where('id', $request->id)->first()->update([
            'category_id' => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
        ]);
        
        // sweet alert
        toast('Data Updated!','success');

        return redirect()->route('subcategory.index');
    }

    public function delete($id){
        // dd($id);
        SubCategory::where('id', $id)->first()->delete();

        // sweet alert
        toast('User Deleted!','info');

        return redirect()->back();
    }
}
