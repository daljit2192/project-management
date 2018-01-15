<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Repositories\Api\Project\ProjectRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
/**
 * Class ProjectController.
 */
class ProjectController extends Controller
{ 

    public function create_project(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'handle' => 'required|string|max:191',
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            return response()->json(array(
                'status' => FALSE,
                'errors' => $errors
            ));
        } else {
            $projectCreate = ProjectRepository::create_project($request->all());
            if(isset($projectCreate) && !empty($projectCreate)){
                $response['status'] = TRUE;
                $response['project'] = $projectCreate->toArray();
                $response['message'] = "Project create successfully.";
                return response()->json($response, 201);
            } else {

            }
        }
    }

    public function get_project_handle($project_name){

        $projectHandleCreate = ProjectRepository::create_project_handle($project_name);
        $response['status'] = TRUE;
        $response['handle'] = $projectHandleCreate;
        $response['message'] = "Handle generated successfully.";
        return response()->json($response, 201);

    }

}

