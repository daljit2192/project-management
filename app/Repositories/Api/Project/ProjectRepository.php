<?php

namespace App\Repositories\Api\User;

use App\Models\Access\Project\Project;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class ProjectRepository.
 */
class ProjectRepository extends BaseRepository
{
    
    public static function create_project($request) {
        $user = JWTAuth::parseToken()->toUser();

        //create object of project for update project Detail
        $createSingleProject = new Project;
        $createSingleProject->fill($request->all());
        $createSingleProject->created_by = $user->id;
        if ($createSingleProject->save()) {
            return $createSingleProject;
        } else {
            return false;
        }
    }

    public static function create_project_handle($projectName) {

        /* set received project name to lower case and insert "-" replacing white space */
        $projectName = strtolower($projectName);
        $projectName = str_replace(" ", "-", $projectName);

        /* set slug status to false untill unique handle not occurs */
        $slugStatus = false;
        $initialValue = 0;
        $projectHandle = $projectName;
        do {
            /* Check if handle exists with $initialValue( 1 ) */
            $projectNameExist = Project::where("handle", $projectHandle)->get();
            if (count($projectNameExist) > 0 && !empty($projectNameExist)) {
                $initialValue = $initialValue + 1;

                /* set handle name with incremented value and check again */
                $projectHandle = $projectName . "-" . $initialValue;
            } else {
                $slugStatus = true;
            }
        } while ($slugStatus == false);

        // print_r($projectHandle);die;
        return $projectHandle;
    }
    
}
