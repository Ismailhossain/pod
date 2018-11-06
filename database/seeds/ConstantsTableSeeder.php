<?php

use App\Role; // or whatever your app namespace is
use App\User ;
use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Faker;

class ConstantsTableSeeder extends Seeder
{
    /**
     *
     */
    public function run()
    {
//        $faker = Faker::create('en_US');
        $RootRole = Role::create([
            'name' => 'Root',
            'slug' => 'root',
        ]);
        $AdminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);
        $ManagerRole = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
        ]);

        $permissionCanRegister = Permission::create([
        'slug' => 'Can_Register',
        'name' => 'Can Register',
        ]);
        $permissionCanRead = Permission::create([
        'slug' => 'Can_Read',
        'name' => 'Can Read',
        ]);
        $permissionCanCreate = Permission::create([
        'slug' => 'Can_Create',
        'name' => 'Can Create',
        ]);
        $permissionCanStore = Permission::create([
        'slug' => 'Can_Store',
        'name' => 'Can Store',
        ]);
        $permissionCanEdit = Permission::create([
        'slug' => 'Can_Edit',
        'name' => 'Can Edit',
        ]);
        $permissionCanUpdate = Permission::create([
        'slug' => 'Can_Update',
        'name' => 'Can Update',
        ]);
        $permissionCanDestroy = Permission::create([
        'slug' => 'Can_Destroy',
        'name' => 'Can Destroy',
        ]);
        $RootRole->givePermissionTo($permissionCanRegister);
        $RootRole->givePermissionTo($permissionCanRead);
        $RootRole->givePermissionTo($permissionCanCreate);
        $RootRole->givePermissionTo($permissionCanStore);
        $RootRole->givePermissionTo($permissionCanEdit);
        $RootRole->givePermissionTo($permissionCanUpdate);
//        $RootRole->givePermissionTo($permissionCanDestroy);
//        $ManagerRole->givePermissionTo($permissionCanRead);

        $RootUser = User::create([
        'name' => 'Ismail',
        'username' => 'ismail',
        'email' => 'ismail@gmail.com',
        'status' => '1',
        'password' => bcrypt('123456'),
        ]);

        $RootUser->roles()->save($RootRole);

//        $users = [
//            ['name' => 'Ismail', 'username' => 'ismail', 'email' => 'ismail@gmail.com', 'password' => bcrypt('123456')],
//        ];
//
//        foreach($users as $user){
//            User::create($user);
//        }



    }
}
