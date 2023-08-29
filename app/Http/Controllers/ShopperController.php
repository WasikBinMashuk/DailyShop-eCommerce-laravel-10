<?php

namespace App\Http\Controllers;

use App\Models\Shopper;
use Illuminate\Http\Request;

class ShopperController extends Controller
{
    public function index(){

        $shoppers = Shopper::latest()->paginate(5);
        // dd($shoppers);
        return view('shoppers', compact('shoppers'));
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required|max:11',
            'address' => 'required'
        ]);
        
        Shopper::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'mobile' => $request->mobile
        ]);

        return redirect()->route('shoppers.index')->with('msg', 'Shopper listed successfully');
    }

    public function edit($id){
        $editShoppers = Shopper::where('id', $id)->first();
        // $editshoppers = Shopper::all()->find($id);
        // dd($editShoppers);
        return view('edit', compact('editShoppers'));
    }

    public function update(Request $request){
        // dd($request->all());
        
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required|max:11',
            'address' => 'required'
        ]);
        
        $shopper = Shopper::where('id', $request->id)->first();
        // dd($shopper);
        $shopper->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'mobile' => $request->mobile
        ]);

        // Shopper->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'address' => $request->address,
        //     'mobile' => $request->mobile
        // ]);

        return redirect()->route('shoppers.index')->with('msg', 'Shopper updated successfully');
    }

    public function delete($id){
        Shopper::where('id', $id)->first()->delete();

        return redirect()->route('shoppers.index')->with('danger', 'Shopper deleted successfully');
    }
}
