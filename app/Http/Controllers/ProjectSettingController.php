<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectSetting;
use Illuminate\Http\Request;

class ProjectSettingController extends Controller
{
    public function save(Request $request, Project $project)
    {
        $response = ['success'=>false, 'message'=>''];

        $cred = $request->only('watch_access','embed_access');
        if ($project->setting()->update($cred)) {
            $response['success'] = true;
            $response['message'] = 'Saved';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to save setting due to system error. Please, try again.';
        }
        return $response;
    }
}
