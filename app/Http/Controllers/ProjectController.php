<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\StudioAccessKey;
use App\Models\User;
use App\Models\VxUser;
use App\Models\VxVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function create (Request $request, $id)
    {
        $response = ['success'=>false, 'message'=>[], 'uuid'=> ''];
        $call_from = $request->query('from');
        $postReq = $request->post();
        $user = null;
        
        // $accessToken = $request->header('Access-Token');

        // if( StudioAccessKey::authenticate($accessToken)) {

            if ($call_from == 'main') {
                $user = VxUser::findBy($id, 'vx_user_id');
            } else if ($call_from == 'studio') {
                $user = VxUser::findBy($id, 'user_id');
            }

            $validate = Validator::make($postReq, [
                'title' => 'string|required',
                'video.image' => 'string|required'
            ]);

            
            if (!$validate->fails()){
                $data = $request->only('title', 'description'); 
                $data['uuid'] = Str::uuid();
                if (!is_null($user)) {
                    if ($project = $user->user->projects()->create($data)) {
                        if ($project->video()->create($request->video)) {
                            $response['success'] = true;
                            $response['message'] = 'Project created';
                            $response['uuid'] = $project->uuid;
                        } else {
                            $response['success'] = false;
                            $response['message'] = 'Project created but video is not added';
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = 'Unable to created project due to system error. Please try again';
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = 'User not found';
                }
                    
            } else {
                $response['success'] = false;
                foreach($postReq as $key => $value) {
                    $response['message'][$key] = $validate->errors()->first($key);
                }
            }
            
        // } else {
        //     $response['success'] = false;
        //     $response['message'] = "Unable to access this page";
        // }
        return $response;
    }

    public function fetch(Request $request)
    {
        $response = ['success'=> false, 'message'=>[]];
        // if (StudioAccessKey::authenticate($request->header('ACCESS-TOKEN'))) {
        //     echo 'You have gotten access to this page';
        // } else {
        //     echo 'Unable to Access this page.';
        // }

        $response['success'] = true;
        $response['message'] = Project::all();

        return $response;
    }

    public function duplicate(Project $project)
    {
        $response = ['success'=> false, 'message'=>''];
    }

    public function delete(Project $project)
    {
        $response = ['success'=>false, 'message'=>''];

        if ($project){
            if ($project->delete()) {
                $response['success'] = true;
                $response['message'] = 'Interactive video deleted.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to delete interactive video due to system error. Please, try again.';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Interactive video not found.';
        }
        return $response;
    }
}
