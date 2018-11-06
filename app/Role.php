<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;

class Role extends Model
{

// If you haven't explicitly given a table name inside your model file, here's what laravel will do for you:
//"The lower-case, plural name of the class will be used as the table name unless another name is explicitly specified. So, in this case, Eloquent will assume the User model stores records in the users table."


    protected $table = 'roles';


    protected $fillable = [
//        'name', 'label', 'permissions',
        'name','slug',
    ];
//    protected $casts = [
//        'permissions' => 'array',
//    ];

    public function permissions () {
        return $this->belongsToMany(Permission::class);
    }
    public function givePermissionTo (Permission $permission) {
        return $this->permissions()->save($permission);
    }


    public function hasPermissions(Permission $permission)
    {
        return $this->permissions->contains($permission);
    }
}
