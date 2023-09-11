<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{   

    public function index(){

        $users = User::latest()->paginate(5);
        
        return view('backend.users.users', compact('users'));
    }

    public function create(){
        return view('backend.users.create');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255||unique:users',
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
        return view('backend.users.edit', compact('editUsers'));
    }

    public function update(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required|max:11',
            'status' => 'required|in:0,1'
        ]);

        $user = User::where('id', $request->id)->first();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'status' => $request->status,
        ]);

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
        return view('backend.users.changePassword');
    }

    public function updatePassword(Request $request){

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        
        if(!Hash::check($request->old_password, auth()->user()->password)){
            toast('Old Password Does not match!','warning');
            return back();
        }
        User::where('id',auth()->user()->id)->update([
            
            'password' => Hash::make($request->password)
        ]);

        toast('Password changed!','success');
        return back();
    }
}
