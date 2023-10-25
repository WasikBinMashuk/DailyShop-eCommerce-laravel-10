<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::with('roles')->get();
            return DataTables::of($users)
                // ->addIndexColumn()
                // ->setRowId(function ($user) {
                //     return $user->id;
                // })
                ->addColumn('action', function ($user) {
                    $actionBtn = '<a href="' . route("users.edit", $user->id) . '" class="btn btn-primary"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></a> 
                <a href="' . route('users.delete', $user->id) . '" class="btn btn-danger" onclick="confirmation(event)"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></a>';
                    return $actionBtn;
                })
                ->addColumn('roles', function (User $user) {
                    if (($user->roles[0]->name ?? '') == 'Super Admin') {
                        return '<span class="badge bg-orange">Super Admin</span>';
                    } else {
                        return $user->roles[0]->name ?? '---';
                    }
                })
                ->editColumn('status', function (User $user) {
                    if ($user->status == 0) {
                        return '<span class="badge bg-red">Inactive</span>';
                    } else {
                        return '<span class="badge bg-green">Active</span>';
                    }
                })
                ->rawColumns(['action', 'status', 'roles'])
                ->toJson();
        }
        return view('backend.users.users');
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|string|email|min:1|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6|max:255',
            'mobile' => 'required|numeric|digits:11',
            'status' => 'required|string|in:0,1'
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'mobile' => $request->mobile,
                'status' => $request->status,
            ]);

            // sweet alert
            toast('User registered!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('users.index')->with('msg', 'User listed successfully');
    }

    public function edit($id)
    {
        try {
            // $editUsers = User::where('id', $id)->first();
            $editUsers = User::findOrFail($id);
            return view('backend.users.edit', compact('editUsers'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:1|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($request->id)],
            'mobile' => 'required|numeric|digits:11',
            'status' => 'required|string|in:0,1'
        ]);


        try {
            $user = User::where('id', $request->id)->first();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => $request->status,
            ]);

            // sweet alert
            toast('User Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('users.index')->with('msg', 'User updated successfully');
    }

    public function delete($id)
    {

        try {
            $user = User::where('id', $id)->first();
            if (($user->roles[0]->name ?? '') == 'Super Admin') {
                // sweet alert
                Alert::warning('Warning!!!', 'Super Admin Cannot be deleted');
                return redirect()->back();
            }

            $user->delete();
            // sweet alert
            toast('User Deleted!', 'info');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('users.index');
    }

    // password changing -------------------------------

    public function changePassword()
    {
        return view('backend.users.changePassword');
    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6|max:255',
        ]);

        try {
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                toast('Old Password Does not match!', 'warning');
                return back();
            }
            User::where('id', auth()->user()->id)->update([

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
