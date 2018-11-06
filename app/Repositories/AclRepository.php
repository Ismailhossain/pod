<?php


namespace App\Repositories;
use App\Permission;
use App\PermissionRole;
use App\Role;
use App\User;
use App\Status;
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

class AclRepository
{

    public $successStatus = 200;

    /**
     * Role constructor.
     */
    public function __construct()

    {


    }

    public function index(){

        $users =  User::all();
        return view('acl.index', compact('users'));
//        return view('acl.index');
    }



    public function getAclList(){
        $users =  User::all();
        $status =  Status::all();
        $roles =  Role::all();
        $permissions =  Permission::all();


//        return view('acl.index', compact('users','status','roles','permissions'));

        return response()->json(['users' => $users,'roles' => $roles,'permissions' => $permissions], $this->successStatus);

//        return response()->json([
//            'body' => view('acl.index', compact('users','status','roles','permissions'))->render(),
////            'users' => $users,
//        ]);

//        return response()
//            ->view('acl.index', $users, 200);


    }









}



