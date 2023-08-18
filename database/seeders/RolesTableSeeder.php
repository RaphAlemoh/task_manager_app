<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'An Admin';
        $role_admin->save();

        $role_staff = new Role();
        $role_staff->name = 'staff';
        $role_staff->description = 'A Staff';
        $role_staff->save();

        $role_customer = new Role();
        $role_customer->name = 'worker';
        $role_customer->description = 'A Worker';
        $role_customer->save();
    }
}
