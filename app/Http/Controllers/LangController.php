<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{
    public function lang(){
        $trendy = Product::where('trendy','1')->get();
        $sliders = Slider::where('status','1')->get();
        $products = Product::orderBy('id','DESC')->take(7)->get();

        return view('frontend.home',compact('products','trendy','sliders'));
    }

    public function lang_change(Request $request){
        // dd($request->all());
        App::setlocale($request->lang);
        session()->put('lang_code',$request->lang);
        return redirect()->back();
    }
}
