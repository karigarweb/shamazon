<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * create default roles
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'customer',  'guard_name' => 'web'],
            ['name' => 'seller',    'guard_name' => 'web'],
        ];

        Role::insert($roles);
    }
}
