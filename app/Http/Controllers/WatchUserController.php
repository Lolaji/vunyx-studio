<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\WatchUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WatchUserController extends Controller
{
    public function create (Request $request, Project $project)
    {
        $response = ['success'=> false, 'message'=>[]];
        $message = [
            'username.required' => 'This field is required.',
            'username.unique' => 'This username already added.'
        ];
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|unique:watch_users'
        ], $message);

        if (!$validate->fails()) {
            $cred = $request->only('username');
            if ($result = $project->watch_users()->create($cred)) {
                $response['success'] = true;
                $response['result'] = $result;
                $response['message'] = 'Username added.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to add username due to system error. Please, try again.';
            }
        } else {
            $response['success'] = false;
            $response['message']['username'] = $validate->errors()->first('username');
        }

        return $response;
    }

    public function delete(WatchUser $watchUser)
    {
        $response = ['success'=>false, 'message'=>''];

        if ($watchUser->delete()) {
            $response['success'] = true;
            $response['message'] = 'Username removed';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to remove username due to system error. Please, try again.';
        }

        return $response;
    }
}
