<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Permission;
use App\Models\Role;
class PermissionroleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Catch Permission first
         $permission = Permission::pluck('id','slug');

         // Add a permission to a role
         $role_manager = Role::where('name', 'Super Admin')->first();
         $role_manager->permission()->attach([

            //============MENU MASTER ===============//
            //MASTER
            $permission['master.index'],
            
            //STAFF
            $permission['staff.index'],
            $permission['staff.tambah'],
            $permission['staff.ubah'],
            $permission['staff.detail'],
            $permission['staff.hapus'],

             //Keamanan
             $permission['security.index'],
 
             $permission['permission.index'],
             $permission['permission.tambah'],
             $permission['permission.ubah'],
 
             $permission['role.index'],
             $permission['role.tambah'],
             $permission['role.ubah'],
             $permission['role.user'],
             $permission['role.hapus'],
         ]);
    }
}
