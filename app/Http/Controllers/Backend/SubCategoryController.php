<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    public function index(Request $request)
    {
        // $subCategories = Category::select('categories.id', 'categories.category_name', 'sub_categories.sub_category_name', 'sub_categories.id', 'sub_categories.category_id')
        // ->Join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
        // ->orderBy('categories.category_name', 'ASC')
        // ->orderBy('sub_categories.sub_category_name', 'ASC')
        // ->paginate(10);

        //query with relationship eloquent
        $subCategories = SubCategory::with('category')
            ->orderBy('sub_category_name', 'ASC')
            ->paginate(10);

        return view('backend.categories.Subcategories', compact('subCategories'));
    }

    public function createSubCat()
    {
        $categories = Category::all();

        return view('backend.categories.subCategoryCreate', compact('categories'));
    }

    public function storeSubCat(Request $request)
    {

        $request->validate([
            'category_id' => 'required|integer',
            'sub_category_name' => 'required|string|min:1|max:255',
        ]);

        try {
            SubCategory::create([
                'category_id' => $request->category_id,
                'sub_category_name' => $request->sub_category_name,
            ]);

            // sweet alert
            toast('Sub Category added!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        try {
            // $editCategory = SubCategory::where('id', $id)->first();
            $editCategory = SubCategory::findOrFail($id);

            $categories = Category::all();

            return view('backend.categories.editSubCategory', compact('editCategory', 'categories'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'sub_category_name' => 'required|string',
        ]);

        try {
            SubCategory::where('id', $request->id)->first()->update([
                'category_id' => $request->category_id,
                'sub_category_name' => $request->sub_category_name,
            ]);

            // sweet alert
            toast('Data Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('subcategory.index');
    }

    public function delete($id)
    {

        try {
            SubCategory::findOrFail($id)->delete();

            // sweet alert
            toast('User Deleted!', 'info');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }

    // getting this request from ajax for dependant dropdown menus
    public function getSubCategory(Request $request)
    {
        $cid = $request->post('cid');

        $subCategories = SubCategory::where('category_id', $cid)->get();
        $html = '<option value="">Select Subcategory</option>';
        foreach ($subCategories as $list) {
            $html .= '<option value="' . $list->id . '">' . $list->sub_category_name . '</option>';
        }
        echo $html;
    }
}
