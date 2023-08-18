<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Ellipsis Baja',
            'email' => 'ellipsis@ellipsis.com',
            'password' => bcrypt('_ec2_fa$#'),
        ]);
    }
}
