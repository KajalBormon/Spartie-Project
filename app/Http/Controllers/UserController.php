<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array {
        return [
            new Middleware('permission:view user', only: ['index']),
            new Middleware('permission:edit user', only: ['edit','update']),
            new Middleware('permission:create user', only: ['create','store']),
            new Middleware('permission:delete user', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view("user.list", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::latest()->get();
        return view("user.create",compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()->route('user.create')->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),

        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('user.index')->with('success','User Created Successfully');


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
        $user = User::find($id);
        $roles = Role::orderBy("name")->get();

        $hasRole = $user->roles->pluck("name");
        return view("user.edit", compact("user",'roles','hasRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string',
            'email'=> 'required|email|min:6',
        ]);
        $user = User::findOrFail( $id );

        if($validator->fails()){
            return redirect()->route('user.edit')->withErrors($validator)->withInput();
        }

        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('user.index')->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request){
        $id = $request->id;
        $user = User::findOrFail($id);
        if($user == null){
            session()->flash('error','User Not Found');
            return response()->json([
                'status' => false,
            ]);
        }

        $user->delete();
        session()->flash('success','User deleted Successfully');

        return response()->json([
            'status'=> true
        ]);
    }
}
