<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VxUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vx_users')->insert([
            [
                'user_id' => 1,
                'vx_user_id' => 1,
                'updated_at' => now(),
                'created_at' => now()
            ]
        ]);
    }
}
