<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {

        $categories = Category::orderBy('category_name', 'ASC')->paginate(5);
        return view('backend.categories.categories', compact('categories'));
    }

    public function createCat()
    {
        return view('backend.categories.createCategory');
    }


    public function store(Request $request)
    {

        $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        // sweet alert
        toast('Category added!', 'success');

        return redirect()->back();
    }

    public function edit($id)
    {

        $editCategory = Category::where('id', $id)->first();
        return view('backend.categories.editCategory', compact('editCategory'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'category_name' => 'required|max:255',
        ]);

        Category::where('id', $request->id)->first()->update([
            'category_name' => $request->category_name,
        ]);

        // sweet alert
        toast('Data Updated!', 'success');

        return redirect()->route('category.index');
    }

    public function delete($id)
    {
        Category::where('id', $id)->first()->delete();

        // sweet alert
        toast('Category Deleted!', 'info');

        return redirect()->back();
    }
}
