<?php

namespace App\Http\Controllers\BD;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $districts = District::with('division')
            ->orderBy('district_name', 'ASC')
            ->paginate(10);

        // $districts = District::latest()->paginate(10);
        return view('backend.BD.district.district', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        return view('backend.BD.district.createDistrict', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required|integer',
            'district_name' => 'required|unique:districts|string|min:1|max:255',
        ]);
        District::create([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
        ]);

        // sweet alert
        toast('District added!', 'success');

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
        try {
            $editDistrict = District::findOrFail($id);
            $divisions = Division::all();

            return view('backend.BD.district.editDistrict', compact('editDistrict', 'divisions'));
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
            'division_id' => 'required|integer',
            'district_name' => ['required', 'string', 'min:1', 'max:255', Rule::unique('districts', 'district_name')->ignore($request->id)],
        ]);

        try {
            District::findOrFail($id)->update([
                'division_id' => $request->division_id,
                'district_name' => $request->district_name,
            ]);

            // sweet alert
            toast('Data Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('districts.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            District::findOrFail($id)->delete();

            // sweet alert
            toast('District Deleted!', 'info');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }
}
