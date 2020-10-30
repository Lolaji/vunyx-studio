<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudioAccessKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('studio_access_keys')->insert([
            [
                'token' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'token' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
