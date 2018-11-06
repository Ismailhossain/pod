<?php


namespace App\Repositories;
use App\Permission;
use App\PermissionRole;
use App\Role;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class RoleRepository
{


    /**
     * Role constructor.
     */
    public function __construct(Role $role)

    {

//        $this->roleManager = $role;

    }

    public function index(){
        $roles =  Role::all();
        $permissions =  Permission::all();
        return view('role.index', compact('roles','permissions'));


//        return View('role.index');  // Need to call this so that route will know which view file need to show

    }

    public function getAllRoles(){

//        $roles = Role::where('slug', '=', $slug);
//        foreach($roles as $role){
//            $id = $slug->id;
//        }
//	    $roles =  Role::all();
//	    foreach ($roles as $role) {
//		    $testslug[] = $role->slug;
//	    }
//	    dd($testslug);

        $roles =  Role::all();
//        $roles =  Role::findOrFail($Role);
        
        $total =  Role::count();
	 
//        foreach($roles as $role){
//            $role['Checkbox'] = '<div id="cbRole"><input name="RoleID[]" type="checkbox" value="' . $role['id'] . '" /></div>';
//        }
//        dd($total);
        return response()->json(array('roles'=>$roles,'total'=>$total),200);
//        return response($roles);


//        return view('role.index', compact('roles'));

//        return response()->json(array('body' => View::make('role.index')->render(), 'title' => 'My Title'));

//        return response()
//            ->view('role.index', $roles, 200);

//        return response()->json([
//            'body' => view('role.index', compact('roles'))->render(),
//            'roles' => $roles,
//        ]);



    }


    public function storeRoles( $request){


        //        $rules = array (
//            'name' => 'required',
//            'slug' => 'required|unique:roles',
//        );
//        $messages = [
//            'required' => 'The :attribute field is required.',
//        ];
//        $validator = Validator::make ( Input::all (), $rules,$messages );
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:roles',
            'permission' => 'required',
            ]
//            [
//                'name.required' => ' The  name field is required.',
//                'slug.required' => ' The slug field is required.',
//            ]
              );
        if ($validator->fails ()) {
//            if ($validator->passes()) {
            $errors  = $validator->errors()->all();
//            $errors [] = $validator->getMessageBag()->toArray();

//            dd($errors);
//            $errors [] = $validator->errors()->getMessages();
//            return Response::json ( array (
//                'errors' => $validator->getMessageBag ()->toArray ()
//            foreach ($errors as $errorvalue) {

                exit(json_encode(array(
                    'result' => 'error',
                    'message' =>  $errors,
//                    'message' => '<li>' . implode('',  $errors ). '</li>' ,
//                    'message' => $validator->errors()->getMessages(),
                )));
//            }

//            return redirect('role')
//                ->withErrors($validator)
//                ->withInput();


        }
//            ) );
        else {
            $role = new Role;
            $role->name = $request->name;
            $role->slug = $request->slug;

            $role->save();

            //Get the role ID created just now

            $new_role = $role->id;
            $permissions = $request->permission;
//            $permissions = explode(",",$request->permission);

            foreach ($permissions as $permission) {
                $permissionrole = new PermissionRole;
                $permissionrole->permission_id = $permission;
                $permissionrole->role_id = $new_role;
                $permissionrole->save();
            }


//            Session::flash('message', 'Role Successfully Created !');
            exit(json_encode(array(
                'result' => 'success',
                't' => 'add',
                'message' => 'Role Created Successfully !'
            )));
//            return Redirect::to('role');
//            return redirect('role');
//            return redirect()->back();
//            return response ()->json ( $role );
//            return response()->json($role, 201);
            return response()->json(array('Result'=> $role), 201);
//            return response()->json(array('Result'=>$role,'code'=>200,'success' => 'Role Successfully Created !'));
        }


//        $this->validate($request, [
//            'name' => 'required',                        // just a normal required validation
//            'slug' => 'required|unique:roles',     // required and must be unique in the table
//        ]);
//        $role = new Role;
//        $role->name = $request->name;
//        $role->slug = $request->slug;
//        $role->save();
//
//        Session::flash('message', 'Role Successfully Created !');
//        return Redirect::to('role');
//        return response()->json($role);

//        return response()->json(['error'=>$validator->errors()->all()]);

    }


    public function editRoleById(Request $request){

        $id = $request->id;
        $ReqUserID = Auth::user()->id;
        $timestr =  Carbon::now();
        $timestr =  $timestr->toDateTimeString();


        if($id !=0){
            $foundRole = DB::table('roles')->select('id','name','slug')->where('id', $id)->first();
            $foundRolePermissions = DB::table('permission_role')->select('id','permission_id','role_id')->where('role_id', $id)->get();;
//        $foundUserRoles = RoleUser::where('user_id', $id)->get();
//            dd($foundRolePermissions);

            exit(json_encode(array(
                'result' => 'success',
                'dataRole' => $foundRole,
                'dataRolePermissions' => $foundRolePermissions,
                'message' => 'Please Edit Role Details!'
            )));

        }else {
            exit(json_encode(array(
                'result' => 'error',
                'message' => '<ul><li><b>Sorry, No Data :(</b></li>'
            )));


        }

    }


    public function updateRoleById(Request $request)
    {

        $timestr =  Carbon::now();
        $timestr =  $timestr->toDateTimeString();
        $timestamp =  Carbon::now()->timestamp;

        $role_id = $request->id;
        $role = Role::find($role_id);
        $role->name = $request->name;
        $role->slug = $request->slug;


        $role->permissions()->sync(Input::get('permission'));

       $update =  $role->save();

        if ($update) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully Updated the Role!'
            )));

        }
    }

    public function destroyRoleById(Request $request)
    {
        $role_id = $request->id;
        $role = Role::find($role_id);
        $del =  $role->delete();

        $permission_role =PermissionRole::where('role_id',$role_id);
        $del_permission_role =  $permission_role->delete();


        if ($del_permission_role) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully deleted the Role!'
            )));

        }
    }







}



