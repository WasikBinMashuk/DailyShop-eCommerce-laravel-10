<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()  
    {  
        $this->middleware('auth');  
    }    

    public function index(){

        $users = User::latest()->paginate(5);
        // dd($shoppers);
        return view('users', compact('users'));
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
        // dd($request->all());

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
            'mobile' => 'required|max:11',
            'status' => 'required|in:0,1'
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
            'status' => $request->status,
        ]);

        // sweet alert
        toast('User registered!','success');

        return redirect()->route('users.index')->with('msg', 'User listed successfully');
    }

    public function edit($id){
        $editUsers = User::where('id', $id)->first();
        // $editshoppers = Shopper::all()->find($id);
        // dd($editShoppers);
        return view('edit', compact('editUsers'));
    }

    public function update(Request $request){
        // dd($request->all());
        
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required|max:11',
            'status' => 'required|in:0,1'
        ]);
        // dd('dada');
        $user = User::where('id', $request->id)->first();
        // dd($user);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'status' => $request->status,
        ]);

        // Shopper->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'address' => $request->address,
        //     'mobile' => $request->mobile
        // ]);

        // sweet alert
        toast('User Updated!','success');

        return redirect()->route('users.index')->with('msg', 'User updated successfully');
    }

    public function delete($id){
        User::where('id', $id)->first()->delete();

        // sweet alert
        toast('User Deleted!','info');

        return redirect()->route('users.index')->with('danger', 'User deleted successfully');
    }

    // password changing -------------------------------

    public function changePassword(){
        return view('changePassword');
    }

    public function updatePassword(Request $request){
        // dd($request->all());

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        // dd('valid');

        
        if(!Hash::check($request->old_password, auth()->user()->password)){
            toast('Old Password Does not match!','warning');
            return back();
        }
        // dd('warning');

        // where('id', $request->id)
        #Update the new Password
        User::where('id',auth()->user()->id)->update([
            
            'password' => Hash::make($request->password)
            // 'password' => $request->password
        ]);

        toast('Password changed!','success');
        return back();
    }
}
