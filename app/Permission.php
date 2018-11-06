<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
class Permission extends Model
{

    protected $table = 'permissions';

    protected $fillable = [
        'name','slug',
    ];


    public function roles () {
        return $this->belongsToMany(Role::class);
    }
}