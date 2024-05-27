<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'Lofus_',
            'firstname' => 'Lucas',
            'lastname' => 'Zuéras',
            'email' => 'lucaszueras23@gmail.com',
            'password' => bcrypt('secret')
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin',
            'guard_name'=>"web"
        ]);
        DB::table('roles')->insert([
            'name' => 'Membre',
            'guard_name'=>"web"
        ]);

        DB::table('permissions')->insert([
            'name' => 'admin',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'create users',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete users',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit users',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'bypass',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'create roles',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete roles',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit roles',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'create permissions',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete permissions',
            'guard_name'=>"web"
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit permissions',
            'guard_name'=>"web"
        ]);


        User::where("id", '1')->first()->assignRole("Admin");
        Role::where("name", "Admin")->first()->syncPermissions(Permission::all());

    }
}
