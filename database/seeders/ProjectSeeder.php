<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            [
                'user_id' => 1,
                'main_site_video_id' => 1,
                'uuid' => Str::uuid(),
                'updated_at' => now(),
                'created_at' => now()
            ]
        ]);
    }
}
