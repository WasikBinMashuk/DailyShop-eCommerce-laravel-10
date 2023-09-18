<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        // dd($sliders);
        return view('backend.sliders.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'slider_title' => 'required|min:1|max:50',
            'slider_link' => 'required|min:1|max:400|url',
            'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=1920,min_height=1080|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $imageName = time().'.'.$request->slider_image->extension();
        Image::make($request->slider_image)->resize(1920,1080)->save('images/sliders/'.$imageName);
        

        Slider::create([
            'slider_title' => $request->slider_title,
            'slider_link' => $request->slider_link,
            'slider_image' => $imageName,
            'status' => $request->status,
        ]);

        // sweet alert
        toast('slider added!','success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editSlider = Slider::where('id', $id)->first();
        

        return view('backend.sliders.edit', compact('editSlider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'slider_title' => 'required|min:1|max:50',
            'slider_link' => 'required|min:1|max:400|url',
            'slider_image' => 'image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=1920,min_height=1080|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $slider = Slider::find($id);
    
            if ($request->file('slider_image')) {
    
                if (file_exists(public_path('images/sliders')."/".$slider->slider_image)) {
    
                    // DELETING THE OLD IMAGE FILE
                     @unlink(public_path('images/sliders' )."/".$slider->slider_image);
             
                }
    
                $imageName = time().'.'.$request->slider_image->extension();
                Image::make($request->slider_image)->resize(1920,1080)->save('images/sliders/'.$imageName);
            }else{
                $imageName = $slider->slider_image;
            }
             
            // dd($imageName);
            // $request->slider_image->move(public_path('images'), $imageName);

            // 1/0;
           $slider->update([
            'slider_title' => $request->slider_title,
            'slider_link' => $request->slider_link,
            'slider_image' => $imageName,
            'status' => $request->status,
            ]);
    
            // sweet alert
            toast('Data Updated!','success');

            return redirect()->route('sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::where('id', $id)->first();

        if (file_exists(public_path('images/sliders')."/".$slider->slider_image)) {
    
            // DELETING THE OLD IMAGE FILE
             @unlink(public_path('images/sliders' )."/".$slider->slider_image);
     
        }

        $slider->delete();

        // sweet alert
        toast('Product Deleted!','info');
        
        return redirect()->back();
    }
}
