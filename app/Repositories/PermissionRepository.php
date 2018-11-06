<?php


namespace App\Repositories;
use Illuminate\Http\Response;
use App\Permission;
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

class PermissionRepository
{


    /**
     * Permission constructor.
     */
    public function __construct(Permission $permission)

    {

//        $this->permissionManager = $permission;

    }

    public function index(){
        $permissions =  Permission::all();
        return view('permission.index', compact('permissions'));


//        return View('permission.index');  // Need to call this so that route will know which view file need to show

    }

    public function getAllPermissions(){

//        $permissions = Permission::where('slug', '=', $slug);
//        foreach($permissions as $permission){
//            $id = $slug->id;
//        }
//	    $permissions =  Permission::all();
//	    foreach ($permissions as $permission) {
//		    $testslug[] = $permission->slug;
//	    }
//	    dd($testslug);

        $permissions =  Permission::all();
//        $permissions =  Permission::findOrFail($Permission);

        $total =  Permission::count();

//        foreach($permissions as $permission){
//            $permission['Checkbox'] = '<div id="cbPermission"><input name="PermissionID[]" type="checkbox" value="' . $permission['id'] . '" /></div>';
//        }
//        dd($total);
        return response()->json(array('permissions'=>$permissions,'total'=>$total),200);
//        return response($permissions);


//        return view('permission.index', compact('permissions'));

//        return response()->json(array('body' => View::make('permission.index')->render(), 'title' => 'My Title'));

//        return response()
//            ->view('permission.index', $permissions, 200);

//        return response()->json([
//            'body' => view('permission.index', compact('permissions'))->render(),
//            'permissions' => $permissions,
//        ]);



    }


    public function storePermissions( $request){

        //        $rules = array (
//            'name' => 'required',
//            'slug' => 'required|unique:permissions',
//        );
//        $messages = [
//            'required' => 'The :attribute field is required.',
//        ];
//        $validator = Validator::make ( Input::all (), $rules,$messages );
        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'slug' => 'required|unique:permissions',
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

//            return redirect('permission')
//                ->withErrors($validator)
//                ->withInput();


        }
//            ) );
        else {
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->slug = $request->slug;
            $permission->save();
//            Session::flash('message', 'Permission Successfully Created !');
            exit(json_encode(array(
                'result' => 'success',
                't' => 'add',
                'message' => 'Permission Created Successfully !'
            )));
//            return Redirect::to('permission');
//            return redirect('permission');
//            return redirect()->back();
//            return response ()->json ( $permission );
//            return response()->json($permission, 201);
            return response()->json(array('Result'=> $permission), 201);
//            return response()->json(array('Result'=>$permission,'code'=>200,'success' => 'Permission Successfully Created !'));
        }


//        $this->validate($request, [
//            'name' => 'required',                        // just a normal required validation
//            'slug' => 'required|unique:permissions',     // required and must be unique in the table
//        ]);
//        $permission = new Permission;
//        $permission->name = $request->name;
//        $permission->slug = $request->slug;
//        $permission->save();
//
//        Session::flash('message', 'Permission Successfully Created !');
//        return Redirect::to('permission');
//        return response()->json($permission);

//        return response()->json(['error'=>$validator->errors()->all()]);

    }


    public function editPermissionById(Request $request){

        $id = $request->id;
        $ReqUserID = Auth::user()->id;
        $timestr =  Carbon::now();
        $timestr =  $timestr->toDateTimeString();


        if($id !=0){
            $foundPermission = DB::table('permissions')->select('id','name','slug')->where('id', $id)->first();


            exit(json_encode(array(
                'result' => 'success',
                'dataPermission' => $foundPermission,
                'message' => 'Please Edit Permission Details!'
            )));

        }else {
            exit(json_encode(array(
                'result' => 'error',
                'message' => '<ul><li><b>Sorry, No Data :(</b></li>'
            )));


        }

    }

    public function updatePermissionById(Request $request)
    {

        $timestr =  Carbon::now();
        $timestr =  $timestr->toDateTimeString();
        $timestamp =  Carbon::now()->timestamp;

        $permission_id = $request->id;
        $permission = Permission::find($permission_id);
        $permission->name = $request->name;
        $permission->slug = $request->slug;

        $update =  $permission->save();

        if ($update) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully Updated the Permission!'
            )));

        }
    }

    public function destroyPermissionById(Request $request)
    {
        $permission_id = $request->id;
        $permission = Permission::find($permission_id);
        $del_permission =  $permission->delete();
        if ($del_permission) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully deleted the Permission!'
            )));

        }
    }






}



