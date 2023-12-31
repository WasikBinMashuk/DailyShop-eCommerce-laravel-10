<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Exception;
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

        return view('backend.sliders.index', compact('sliders'));
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
        $request->validate([
            'slider_title' => 'required|string|min:1|max:50',
            'slider_link' => 'required|string|min:1|max:400|url',
            'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=1920,min_height=1080|max:2048',
            'status' => 'required|string|in:0,1',
        ]);


        try {
            $imageName = time() . '.' . $request->slider_image->extension();
            Image::make($request->slider_image)->resize(1920, 1080)->save('images/sliders/' . $imageName);

            Slider::create([
                'slider_title' => $request->slider_title,
                'slider_link' => $request->slider_link,
                'slider_image' => $imageName,
                'status' => $request->status,
            ]);

            // sweet alert
            toast('slider added!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $editSlider = Slider::findOrFail($id);

            return view('backend.sliders.edit', compact('editSlider'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'slider_title' => 'required|string|min:1|max:50',
            'slider_link' => 'required|string|min:1|max:400|url',
            'slider_image' => 'image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=1920,min_height=1080|max:2048',
            'status' => 'required|string|in:0,1',
        ]);

        try {
            $slider = Slider::findOrFail($id);

            if ($request->file('slider_image')) {

                if (file_exists(public_path('images/sliders') . "/" . $slider->slider_image)) {

                    // DELETING THE OLD IMAGE FILE
                    @unlink(public_path('images/sliders') . "/" . $slider->slider_image);
                }

                $imageName = time() . '.' . $request->slider_image->extension();
                Image::make($request->slider_image)->resize(1920, 1080)->save('images/sliders/' . $imageName);
            } else {
                $imageName = $slider->slider_image;
            }

            // dd($imageName);
            // $request->slider_image->move(public_path('images'), $imageName);

            $slider->update([
                'slider_title' => $request->slider_title,
                'slider_link' => $request->slider_link,
                'slider_image' => $imageName,
                'status' => $request->status,
            ]);

            // sweet alert
            toast('Data Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $slider = Slider::findOrFail($id);

            if (file_exists(public_path('images/sliders') . "/" . $slider->slider_image)) {

                // DELETING THE OLD IMAGE FILE
                @unlink(public_path('images/sliders') . "/" . $slider->slider_image);
            }

            $slider->delete();

            // sweet alert
            toast('Slider Image Deleted!', 'info');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }
}
