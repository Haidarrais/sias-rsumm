<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('pages.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        $input->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,except,id',
            'email' => 'required|string|max:255|email|unique:users,email,except,id',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required',
        ]);

        $user = User::create([
            'name' => $input->name,
            'username' => $input->username,
            'email' => $input->email,
            'password' => Hash::make($input->password),
        ]);

        $user->assignRole($input->roles);

        toast('User ' . $input->name . ' berhasil di dibuat' . ' dengan role ' . $input->roles, 'success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::with('roles')->where('id','=',$id)->first();
        return response()->json([
            'status'    =>  1,
            'data'      =>  $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->roles) {
            $user->removeRole($user->roles[0]->name);
            $user->assignRole($request->roles);
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        toast('User berhasil di edit', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'berhasil hapus user');
    }
}
