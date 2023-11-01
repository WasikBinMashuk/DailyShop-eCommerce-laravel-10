<?php

namespace App\Http\Controllers\BD;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Exception;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::latest()->get();
        return view('backend.BD.division.division', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.BD.division.createDivision');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'division_name' => 'required|unique:divisions|string|min:1|max:255',
        ]);
        Division::create([
            'division_name' => $request->division_name,
        ]);

        // sweet alert
        toast('Division added!', 'success');

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
            $editDivision = Division::findOrFail($id);

            return view('backend.BD.division.editDivision', compact('editDivision'));
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
            'division_name' => 'required|unique:divisions|string|min:1|max:255',
        ]);

        try {
            $slider = Division::findOrFail($id);

            $slider->update([
                'division_name' => $request->division_name,
            ]);

            // sweet alert
            toast('Data Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('divisions.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Division::findOrFail($id)->delete();

            // sweet alert
            toast('Division Deleted!', 'info');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }
}
