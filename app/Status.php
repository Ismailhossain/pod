<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

// If you haven't explicitly given a table name inside your model file, here's what laravel will do for you:
//"The lower-case, plural name of the class will be used as the table name unless another name is explicitly specified. So, in this case, Eloquent will assume the User model stores records in the users table."


    protected $table = 'status';


    protected $fillable = [
        'status_id','status_name',
    ];
//    protected $casts = [
//        'permissions' => 'array',
//    ];


}
