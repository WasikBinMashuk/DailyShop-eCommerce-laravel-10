<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{

    public function lang_change(Request $request)
    {
        App::setlocale($request->lang);
        session()->put('lang_code', $request->lang);
        return redirect()->back();
    }
}
