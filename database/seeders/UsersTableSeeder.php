<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_admin  = Role::where('name', 'admin')->first();
        $role_staff  = Role::where('name', 'staff')->first();
        $role_customer  = Role::where('name', 'worker')->first();

        $user1 = User::create([
            'name' => 'Ellipsis Baja',
            'email' => 'admin@ellipsis.com',
            'password' => bcrypt('_ec2_fa$#'),
        ]);
        $user1->roles()->attach($role_admin);

        $user2 = User::create([
            'name' => 'Ellipsis Baja',
            'email' => 'staff@ellipsis.com',
            'password' => bcrypt('_ec2_fa$#'),
        ]);
        $user2->roles()->attach($role_staff);

        $user3 = User::create([
            'name' => 'Ellipsis Baja',
            'email' => 'worker@ellipsis.com',
            'password' => bcrypt('_ec2_fa$#'),
        ]);
        $user3->roles()->attach($role_customer);
    }
}
