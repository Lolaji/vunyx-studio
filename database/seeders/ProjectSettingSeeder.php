<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = DB::table('projects')->get();
        $data=[];
        foreach($projects as $key => $value) {
            $data[$key] = [
                'project_id'=>$value->id,
                'created_at'=> $value->created_at,
                'updated_at' => $value->updated_at
            ];
        }

        // print_r($data);
        $this->insert($data);
    }

    private function insert($data)
    {
        $insert = DB::table('project_settings')->insert($data);

        if ($insert) {
            echo "Insert successfull \n\r";
        } else {
            echo "Error occured wnen inserting \n\r";
        }
    }
}
