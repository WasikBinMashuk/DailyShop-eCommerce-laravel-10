<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $profile = Customer::find(Auth::guard('customer')->user()->id);
        $orders = Order::with(['orderDetails'])->where('customer_id',  Auth::guard('customer')->user()->id)->orderBy('id', 'DESC')->get();

        return view('frontend.customer-dashboard', compact('profile', 'orders'));
    }

    public function profileUpdate(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:20',
            'email' =>  ['required','string' ,'email:rfc,dns', 'max:255', Rule::unique('customers')->ignore(Auth::guard('customer')->user()->id)],
            'mobile' => 'required|numeric|digits:11',
        ]);

        try {
            Customer::find(Auth::guard('customer')->user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                ]);

            // sweet alert
            toast('Profile Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }

    public function addressUpdate(Request $request)
    {
        $request->validate([
            'address' => 'required|string|min:1|max:255',
            'city' => 'required|string|min:1|max:50',
            'country' => 'required|string|min:1|max:50',
            'postcode' => 'required|numeric|digits_between:4,6',
        ]);

        try {
            Customer::find(Auth::guard('customer')->user()->id)
                ->update([
                    'address' => $request->address,
                    'city' => $request->city,
                    'country' => $request->country,
                    'postcode' => $request->postcode,
                ]);

            // sweet alert
            toast('Address Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ]);

        try {
            if (!Hash::check($request->old_password, Auth::guard('customer')->user()->password)) {
                toast('Old Password Does not match!', 'warning');
                return back();
            }
            Customer::find(Auth::guard('customer')->user()->id)->update([
                'password' => Hash::make($request->password)
            ]);

            toast('Password changed!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return back();
    }
}
