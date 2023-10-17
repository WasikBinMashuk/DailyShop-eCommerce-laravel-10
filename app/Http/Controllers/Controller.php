<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        // Load your objects
        $shopCategories = Category::all();

        // Make it available to all views by sharing it for the header category dropdown
        view()->share('shopCategories', $shopCategories);
    }
}
