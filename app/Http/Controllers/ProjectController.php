<?php

namespace App\Http\Controllers;

use App\Models\EmbedDomain;
use App\Models\Project;
use App\Models\StudioAccessKey;
use App\Models\User;
use App\Models\VxUser;
use App\Models\VxVideo;
use App\Models\WatchUser;
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
                $data['uuid'] = (string) Str::uuid();
                if (!is_null($user)) {
                    if ($project = $user->user->projects()->create($data)) {
                        if ($project->video()->create($request->video)) {
                            $project->setting()->create();
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

    public function update(Request $request, Project $project)
    {
        $response = ['success'=>false, 'message'=>''];
        $cred = $request->only('title', 'description');
        if ($project->update($cred)){
            $response['success'] = true;
            $response['message'] = 'Saved';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to save setting due to system error. please, try again later.';
        }

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

    public function addDomain (Request $request, Project $project)
    {
        $response = ['success'=>false, 'result'=>null, 'message'=>[]];
        
        $message = [
            'domain.unique' => 'Domain already added.',
            'domain.required' => 'This field is required.'
        ];

        $validate = Validator::make($request->all(), [
            'domain'=>'required'
        ], $message);
        
        
        if (! $validate->fails()) {
            $cred = $request->only('domain');
            if ($domain = $project->embed_domains()->create($cred)) {
                $response['success'] = true;
                $response['result'] = $domain;
                $response['message'] = 'Domain added successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to add domain';
            }
        } else {
            $response['success'] = false;
            foreach($request->all() as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
    }

    public function removeDomain (Request $request, EmbedDomain $domain)
    {
        $response = ['success'=> false, 'message'=>''];

        if ($domain->delete()) {
            $response['success'] = true;
            $response['message'] = 'Domain removed';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to remove domain due to system error. Please try agaib';
        }
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
