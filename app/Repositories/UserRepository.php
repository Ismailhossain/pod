<?php


namespace App\Repositories;
use Illuminate\Http\Response;
use App\Role;
use App\User;
use App\RoleUser;
use App\Permission;
use App\Status;
use Illuminate\Http\Request;
//use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use PDF;

class UserRepository
{


    /**
     * User constructor.
     */
    public function __construct(User $user)

    {

//        $this->userManager = $user;

    }

    public function index(){
        $roles = Role::all();
        $users =  User::all();
        //        dd($users);
//        $users = User::paginate(1);
        $status =  Status::all();
        return view('user.index', compact('users','roles','status'));


//        return View('user.index');  // Need to call this so that route will know which view file need to show

    }

    public function getAllUsers(){

//        $users = User::where('slug', '=', $slug);
//        foreach($users as $user){
//            $id = $slug->id;
//        }
//	    $users =  User::all();
//	    foreach ($users as $user) {
//		    $testslug[] = $user->slug;
//	    }
//	    dd($testslug);

        $users =  User::all();
//        $users =  User::findOrFail($User);

        $total =  User::count();

//        foreach($users as $user){
//            $user['Checkbox'] = '<div id="cbUser"><input name="UserID[]" type="checkbox" value="' . $user['id'] . '" /></div>';
//        }
//        dd($total);
        return response()->json(array('users'=>$users,'total'=>$total),200);
//        return response($users);


//        return view('user.index', compact('users'));

//        return response()->json(array('body' => View::make('user.index')->render(), 'title' => 'My Title'));

//        return response()
//            ->view('user.index', $users, 200);

//        return response()->json([
//            'body' => view('user.index', compact('users'))->render(),
//            'users' => $users,
//        ]);



    }


    public function storeUsers(Request $request){

        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $status_id = $request->status_id;
//        $role_name = $request->role_name;
        $role_name = explode(",",$request->role_name);
        $password = $request->password;
        $passwordlen = strlen($password);
        $password_confirmation = $request->password_confirmation;


//        $imagefilename = $imagefile->getClientOriginalName() . '_' . str_random(8) . '_' . $timestamp;
//        dd($imagefilename);
//
//
//
//
//        if($request->hasfile('user_image'))
//        {
//            $file = $request->file('user_image');
//            $file= time().$file->getClientOriginalName();
////            $file->move(public_path().'/images/', $name);
//        }
////        $user_image = $request->user_image;
////        $user_image = $user_image->getClientOriginalName();
//
//        dd($file);


        $err = "";


        $error = "<ul>";

        if (!$name) {
            $err = 1;
            $error .= "<li><b>Please key in Name</b></li>";
        }
        if (!$username) {
            $err = 1;
            $error .= "<li><b>Please key in Username</b></li>";
        }
        if (!$email) {
            $err = 1;
            $error .= "<li><b>Please key in Email</b></li>";
        }else {

            $FoundDupEmail = DB::table('users')->select('email')->where('email', $email)->first();
            if ($FoundDupEmail) {
                $err = 1;
                $error .= "<li><b>Please key in valid Email. Duplicate Email found.</b></li>";
            }
        }
        if (!isset($status_id)) {
            $err = 1;
            $error .= "<li><b>Please key in Status</b></li>";
        }

        foreach ($role_name as $key => $value) {
            if (empty($value)) {
                $err = 1;
                $error .= "<li><b>Please key in Role</b></li>";
            }
        }
//        if (!$role_name) {
//            $err = 1;
//            $error .= "<li><b>Please key in Role</b></li>";
//        }
        if (!$password && $passwordlen != 6) {
            $err = 1;
            $error .= "<li><b>Please key in 6 digit Password</b></li>";
        }

        if ($password != $password_confirmation) {
            $err = 1;
            $error .= "<li><b>Please key in Same Password</b></li>";
        }


        $error .= "</ul>";


        if ($err == 1) {
            exit(json_encode(array(
                'result' => 'error',
                'message' => $error,
            )));
        }else{

            $timestamp =  Carbon::now()->timestamp;
//            $timestamp =  $timestamp->timestamp();

            $user = new User;
            $user->name = $name;
            $user->username = $username;
            $user->email = $email;
            $user->status = $status_id;
            $user->email = $request->email;
            $user->password = Hash::make($password);


//        if($request->hasfile('user_image'))
//        {
            //for image uploading starts

            $imagefile = $request->user_image;
//            dd($imagefile);
            if($imagefile != "undefined"){

            // To explode from ajax request

//            $imagefile = explode("\\",$imagefile);
//            $imagefile = $imagefile[2];
//            $imagefile = str_replace('"', '', $imagefile);

//            dd($imagefile);
            $imagefilename =  str_random(8) . '_' . $timestamp . '_' . $imagefile->getClientOriginalName();
//            $imagefilename =  str_random(8) . '_' . $timestamp . '_' . $imagefile;
//            dd($imagefilename);

            $imagefile->move(public_path() . '/images/', $imagefilename);

//        }


            $user->image = $imagefilename;
            }
            else {

                $user->image = '';

            }
            //image uploading ends
//            $success['token'] =  $user->createToken('MyApp')->accessToken;
//            $user->register_token = $success['token'];

            $user->save();

            //Get the user ID created just now

            $new_user = $user->id;

//            foreach ($request->input('role_name') as $roles) {
            foreach ($role_name as $roles) {
                $roleuser = new RoleUser;
                $roleuser->role_id = $roles;
                $roleuser->user_id = $new_user;
                $roleuser->save();
            }


            exit(json_encode(array(
                'result' => 'success',
                't' => 'add',
                'message' => 'User Created Successfully !'
            )));


//            Session::flash('message', 'Successfully created User!');
//            return Redirect::to('user');

        }
    }



    public function editUsersById(Request $request){

        $id = $request->id;
        $ReqUserID = Auth::user()->id;
        $timestr =  Carbon::now();
        $timestr =  $timestr->toDateTimeString();


        if($id !=0){
        $foundUser = DB::table('users')->select('id','name','username','email','status','password',
                    'image')->where('id', $id)->first();
        $foundUserRoles = DB::table('role_user')->select('id','user_id','role_id')->where('user_id', $id)->get();;
//        $foundUserRoles = RoleUser::where('user_id', $id)->get();
//            dd($foundUserRoles);

            exit(json_encode(array(
                'result' => 'success',
                'dataUser' => $foundUser,
                'dataUserRoles' => $foundUserRoles,
                'message' => 'Please Edit User Details!'
            )));

        }else {
            exit(json_encode(array(
                'result' => 'error',
                'message' => '<ul><li><b>Sorry, No Data :(</b></li>'
            )));


        }

    }

    public function updateUsersById(Request $request)
    {
//        $id = $request->hidden_user_id;
//        dd($id);

        $ReqUserID = Auth::user()->id;
        $timestr =  Carbon::now();
        $timestr =  $timestr->toDateTimeString();
        $timestamp =  Carbon::now()->timestamp;

//        $user_id = Input::get('hidden_user_id');
        $user_id = $request->id;
        $user = User::find($user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->status = $request->status_id;
        $hidden_user_image = $request->hidden_user_image;
        $role_name = explode(",",$request->role_name);
//dd($hidden_user_image);

        //for image uploading starts

        $imagefile = $request->user_image;
//dd($imagefile);

        if($imagefile != "undefined") {
            $imagefilename =  str_random(8) . '_' . $timestamp . '_' . $imagefile->getClientOriginalName();
            $imagefile->move(public_path() . '/images/', $imagefilename);
            $user->image =  $imagefilename;
        }else {
            $user->image = $hidden_user_image;
        }

        //image uploading ends


        $user->roles()->sync($role_name);

        $user->save();

//        $found = DB::table('users')->select('id')->where('id', $id)->first();
//        if ($found) {
//        }


        exit(json_encode(array(
            'result' => 'success',
            'message' => 'Successfully updated User!'
        )));



//        Session::flash('message', 'Successfully updated User!');
//        return Redirect::to('user');
    }


    public function destroyUsersById(Request $request)
    {
        $user_id = $request->id;
        $del = User::find($user_id);
        $del->delete();

        $role_user =RoleUser::where('user_id',$user_id);
        $del_role_user =  $role_user->delete();

        if ($del_role_user) {
            exit(json_encode(array(
                'result' => 'success',
                'message' => 'Successfully deleted the user!'
            )));

        }
    }

}



