<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Permission;
use App\Models\AppMeta;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        echo PHP_EOL , 'cleaning old data....', PHP_EOL;

        Schema::disableForeignKeyConstraints();

        User::truncate();
        Role::truncate();
        UserRole::truncate();
        Permission::truncate();
        AppMeta::truncate();
        DB::table('roles_permissions')->truncate();
        DB::table('users_permissions')->truncate();
        DB::table('notifications')->truncate();

        Schema::enableForeignKeyConstraints();

        $this->call(RolesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
