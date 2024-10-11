<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array {
        return [
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:edit role', only: ['edit','update']),
            new Middleware('permission:create role', only: ['create','store']),
            new Middleware('permission:delete role', only: ['destroy']),

        ];
    }
    public function index(){
        $roles = Role::orderBy('name','ASC')->paginate(10);
        return view("role.list",compact('roles'));
    }

    public function create(Request $request){
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('role.create', compact('permissions'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name"=> "required|unique:roles|min:3",
        ]);

        if ($validator->passes()) {
           $role = Role::create([
                "name"=> $request->name,
           ]);
           if(!empty($request->permission)){
                foreach($request->permission as $permission){
                    $role->givePermissionTo($permission);
                }
           }

           return redirect()->route('role.index')->with("success","Role Added Successfully");
        }else{
            return redirect()->route('role.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::orderBy('name','ASC')->get();
        $hasPermission = $role->permissions->pluck('name');

        return view('role.edit',compact('role','permissions','hasPermission'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            "name"=> "required",
        ]);
        $role = Role::findOrFail($id);


        if ($validator->passes()) {
            $role->update([
                "name"=> $request->name,
            ]);
            if(!empty($request->permission)){
                $role->syncPermissions($request->permission);
            }else{
                $role->syncPermissions([]);
            }

           return redirect()->route('role.index')->with("success","Role Updated Successfully");
        }else{
            return redirect()->route('role.edit',$id)->withErrors($validator)->withInput();
        }
    }

    public function destroy(Request $request){
        $id = $request->id;
        $role = Role::findOrFail($id);

        if($role == null){
            session()->flash('error','Role Not Found');
            return response ()->json([
                'status' => false,
            ]);
        }

        $role->delete();

        session()->flash('success','Role Deleted Successfully');
        return response()->json([
            'status'=> true,
        ]);
    }
}
