<?php

use App\Models\Security\PermissionData;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayOfPermissionNames = ['role', 'moderator','blog_cat','blog','country','city','slider','coupon','category','complaintype','complainstatus'];


        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission."-list", 'guard_name' => 'master'];
        });
        Permission::insert($permissions->toArray());


        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission."-add", 'guard_name' => 'master'];
        });
        Permission::insert($permissions->toArray());
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission."-edit", 'guard_name' => 'master'];
        });
        Permission::insert($permissions->toArray());
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission."-del", 'guard_name' => 'master'];
        });
        Permission::insert($permissions->toArray());
        // $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
        //     return ['name' => $permission, 'guard_name' => 'master'];
        // });
       // Permission::insert($permissions->toArray());
    }
}
