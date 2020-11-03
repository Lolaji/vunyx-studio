<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElementController extends Controller
{
    public function save(Request $request, Project $project, $id=null)
    {
        $response = ['success'=>false, 'id'=> null, 'message'=>[]];

        $validate = Validator::make($request->all(), [
            'title' => 'string|required',
            'type' => 'string|required',
            'text' => 'string|required',
            'action' => 'required',
            'from_time' => 'string|required',
            'to_time' => 'string|required'
        ]);


        if (!$validate->fails()){
            if (!is_null($id)){
                if (Element::find($id)->update($request->post())){
                    $response['success'] = true;
                    $response['message'] = 'Saved';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to save due to system error. Please try again.';
                }
            } else {
                if ($element = $project->elements()->create($request->post())) {
                    $response['success'] = true;
                    $response['id'] = $element->id;
                    $response['message'] = 'Saved';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Unable to save due to system error. Please try again.';
                }
            }
        } else {
            $response['success'] = false;
            foreach($request->all() as $key => $value) {
                $response['message'][$key] = $validate->errors()->first($key);
            }
        }
        return $response;
    }

    public function remove(Project $project, $id)
    {
        $response = ['success'=>false, 'message'=>''];

        if ($project->elements()->findOrFail($id)->delete()){
            $response['success'] = true;
            $response['message'] = 'Removed';
        } else {
            $response['success'] = false;
            $response['message'] = 'Unable to remove element due to system error. Please, try again.';
        }
        return $response;
    }
}
