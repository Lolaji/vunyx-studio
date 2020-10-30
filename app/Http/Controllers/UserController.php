<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\StudioAccessKey;
use App\Models\User;
use App\Models\VxUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if (StudioAccessKey::authenticate($request->header('ACCESS-TOKEN'))) {
            echo 'You have gotten access to this API';
        } else {
            echo 'Unable to Access this page.';
        }
    }

    protected function create(Request $request)
    {
        $response = ['success'=>false, 'message'=>[]];

        $validate = Validator::make($request->all(), [
            'vx_user_id' => 'required',
            'name' => 'string|required',
            'email' => 'string|required|email|unique:users',
            'password' => 'string|required'
        ]);

        if (!$validate->fails()){
            $data = $request->only('name', 'email');
            $data['password'] = Hash::make($request->password);
            
            if ($user = User::create($data)){
                $user->vx()->create(['vx_user_id'=> $request->vx_user_id]);

                $response['success'] = true;
                $response['message'] = 'Registration successful.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to register user due to system error. Please, try again.';
            }
        } else {
            $response['success'] = false;
            foreach($request->all() as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
    }

    public function vxAuthentication(Request $request)
    {
        
    }

    public function vxAuth (Request $request)
    {
        $id = $request->query('uid');
        $puuid = $request->query('puuid');
        $is_project_exist = Project::where('uuid', $puuid)->exists();

        if ($id && $puuid && $is_project_exist){
            $vx = VxUser::findBy($id, 'vx_user_id');
            if (Auth::check()){
                return redirect('/studio/'.$puuid);
            } else {
                if (!is_null($vx) && !is_null($vx->user)) {
                    if (Auth::loginUsingId($vx->user->id)) {
                        return redirect('/studio/'.$puuid);
                    } else {
                        return redirect('http://vunyx.com/login.html');
                    }
                }
            }
        } else {
            return redirect('http://vunyx.com/login.html');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
