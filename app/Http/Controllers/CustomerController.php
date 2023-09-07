<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(5);
        return view('customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|max:100|unique:customers',
            'password' => 'required|confirmed|min:6',
            'mobile' => 'required|max:11',
            // 'status' => 'required|in:0,1'
        ]);
        
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
            // 'status' => $request->status,
        ]);

        // sweet alert
        toast('Customer registered!','success');

        return redirect()->route('customers.index');
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
        $editCustomer = Customer::where('id', $id)->first();
        return view('customers.edit', compact('editCustomer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|max:20',
            'email' => ['required','max:100', Rule::unique('customers','email')->ignore($id)],
            'mobile' => 'required|max:11',
            'status' => 'required|in:0,1'
        ]);
        

        $customer = Customer::where('id', $id)->first();

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'status' => $request->status,
        ]);

        // sweet alert
        toast('Customer Updated!','success');

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        Customer::where('id', $id)->first()->delete();

        // sweet alert
        toast('Customer Deleted!','info');

        return redirect()->route('customers.index');
    }
}
