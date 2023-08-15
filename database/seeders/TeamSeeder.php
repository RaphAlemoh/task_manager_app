<?php

namespace Database\Seeders;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        Team::insert([
            ['name' => 'Ellipsis',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Covado',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Light',  'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
