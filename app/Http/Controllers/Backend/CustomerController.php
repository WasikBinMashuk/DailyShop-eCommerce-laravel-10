<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerFormRequest;
use App\Models\Customer;
use Exception;
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
        return view('backend.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('backend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerFormRequest $request)
    {
        try {
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'mobile' => $request->mobile,
                // 'status' => $request->status,
            ]);

            // sweet alert
            toast('Customer registered!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('customers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $editCustomer = Customer::findOrFail($id);
            return view('backend.customers.edit', compact('editCustomer'));
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
            'name' => 'required|string|min:1|max:30',
            'email' => ['required', 'string', 'email', 'min:1', 'max:100', Rule::unique('customers', 'email')->ignore($id)],
            'mobile' => 'required|numeric|digits:11',
            'status' => 'required|string|in:0,1'
        ]);

        try {
            $customer = Customer::where('id', $id)->first();

            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => $request->status,
            ]);

            // sweet alert
            toast('Customer Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Customer::findOrFail($id)->delete();

            // sweet alert
            toast('Customer Deleted!', 'info');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('customers.index');
    }
}
