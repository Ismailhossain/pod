<?php namespace App;


use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    //

//    protected $fillable = ['permission_id', 'role_id'];    // To protect attributes


    protected $table = 'permission_role';





//    public function roles(){
//        return $this->belongsTo(Role::class);
//
//    }
//
//    public function permissions(){
//        return $this->belongsTo(Permission::class);
//
//    }
//    public function user(){
//        return $this->belongsToMany(User::class);
//
//    }

}
