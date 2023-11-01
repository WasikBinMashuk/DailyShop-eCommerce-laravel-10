<?php

namespace App\Http\Controllers\BD;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\Thana;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ThanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thanas = Thana::with(['division', 'district'])->get();
        return view('backend.BD.thana.thana', compact('thanas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::get();

        return view('backend.BD.thana.createThana', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required|integer',
            'district_id' => 'required|integer',
            'thana_name' => 'required|unique:thanas|string|min:1|max:255',
        ]);
        Thana::create([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'thana_name' => $request->thana_name,
        ]);

        // sweet alert
        toast('Thana added!', 'success');

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
        // $editProduct = Product::where('id', $id)->first();
        $editThana = Thana::findOrFail($id);

        $divisions = Division::all();

        $districts = District::where('id', $editThana->district_id)->get();

        return view('backend.BD.thana.editThana', compact('editThana', 'divisions', 'districts'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'division_id' => 'required|integer',
            'district_id' => 'required|integer',
            'thana_name' => ['required', 'string', 'min:1', 'max:255', Rule::unique('thanas', 'thana_name')->ignore($id)],
        ]);


        Thana::find($id)->update([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'thana_name' => $request->thana_name,
        ]);

        // sweet alert
        toast('Data Updated!', 'success');


        return redirect()->route('thanas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Thana::findOrFail($id)->delete();

        // sweet alert
        toast('Thana Deleted!', 'info');


        return redirect()->back();
    }


    // getting this request from ajax for dependant dropdown menus
    public function getDistricts(Request $request)
    {
        $cid = $request->post('cid');

        $districts = District::where('division_id', $cid)->get();
        $html = '<option value="">Select District</option>';
        foreach ($districts as $list) {
            $html .= '<option value="' . $list->id . '">' . $list->district_name . '</option>';
        }
        echo $html;
    }
}
