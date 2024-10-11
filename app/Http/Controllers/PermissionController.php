<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array {
        return [
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:edit permission', only: ['edit','update']),
            new Middleware('permission:create permission', only: ['create','store']),
            new Middleware('permission:delete permission', only: ['destroy']),

        ];
    }
    public function index(){
        $permissions = Permission::orderBy('created_at','DESC')->paginate(10);
        return view("permission.list",compact('permissions'));
    }

    public function create(){
        return view("permission.create");
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name"=> "required|unique:permissions|min:3",
        ]);

        if ($validator->passes()) {
           Permission::create([
              "name"=> $request->name
           ]);
           return redirect()->route('permission.index')->with("success","Permission Added Successfully");
        }else{
            return redirect()->route('permission.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permission.edit',compact('permission'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            "name"=> "required|unique:permissions,name,'.$id.','id|min:3",
        ]);
        $permission = Permission::findOrFail($id);
        if($validator->passes()){
            $permission->update([
                "name"=> $request->name
            ]);
            return redirect()->route("permission.index")->with("success","Permission Updated Successfully");
        }else{
            return redirect()->route("permission.edit",$id)->withErrors($validator)->withInput();
        }
    }

    public function destroy(Request $request){
        $id = $request->id;
        $permission = Permission::findOrFail($id);

        if($permission ==  null){
            session()->flash("error","Permission Not Found");
            return response()->json([
                "status"=> false,
            ]);
        }
        $permission->delete();

        session()->flash('success','Permission Deleted Successfully');

        return response()->json([
            'status'=> true,
        ]);

    }
}
