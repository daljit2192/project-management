<?php

namespace App\Repositories\Api\task;

use App\Models\Access\Task\Task;
use App\Models\Access\ProjectAssignees\ProjectAssignees;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class ProjectRepository.
 */
class TaskRepository extends BaseRepository
{

	/* Function will store project details in projects table and requires project details as $request param */
    public static function create_project($request) {
        $user = JWTAuth::parseToken()->toUser();

        /* create object of project for update project Detail */
        $createSingleProject = new Project;
        $createSingleProject->fill($request);

        /* Get current login user ID from JWT AUTH token */
        $createSingleProject->created_by = $user->id;
        if ($createSingleProject->save()) {
            $assignProjectDetails = array(
                "project_id" => $createSingleProject->id,
                "user_id" => $request["users"],
                "created_by" => $user->id,
            );

            /* AFter saving project call function that will save assignees of project in database */
            $saveAssigneeStatus = self::save_project_assigness($request["users"], $assignProjectDetails);
            if($saveAssigneeStatus){
                return $createSingleProject;
            } else {
                return false;    
            }
        } else {
            return false;
        }
    }


    /* Function that will update project details and also assignees details if changes */
    public static function update_project($request) {
        $user = JWTAuth::parseToken()->toUser();
        $updateSingleProject = Project::find($request["id"]);
        $updateSingleProject->fill($request);
        if ($updateSingleProject->save()) {
            $assignProjectDetails = array(
                "project_id" => $updateSingleProject->id,
                "user_id" => $request["users"],
                "created_by" => $user->id,
            );

            /* Check if their is any assignee of the project if not, then save the new assignees in db */
            $currentProjectAssignee = ProjectAssignees::where("project_id", $updateSingleProject->id)->get();
            if (count($currentProjectAssignee) == 0) {

                $assignProjectStatus = self::assign_project($assignProjectDetails);
                if ($assignProjectStatus) {
                    return $updateSingleProject;
                }
            } else {

            	 /* If assignees already exist then check for change in new assignees and current assignees */
                $currentAssignees = [];
                foreach ($currentProjectAssignee as $projectAssignee) {

                	/* Create array with only ids of current assignees */
                    array_push($currentAssignees, $projectAssignee->user_id);
                }
                $updateProjectAssignee = self::update_project_assignee($assignProjectDetails, $currentAssignees);
                if ($updateProjectAssignee) {
                    return $updateSingleProject;
                }
            }
        } else {
            return false;
        }
    }

    /* Function will update assignees of project */
    public static function update_project_assignee($request, $currentAssignees) {
        $user = JWTAuth::parseToken()->toUser();
        
        /* Check if assignees array user_id is empty or not */
        if ($request["user_id"] != null || $request["user_id"] != "") {

            $newAssignees = [];
            $newAssignees = explode(",", $request["user_id"]);
            $common = array_intersect($currentAssignees, $newAssignees);
            $deleteAssignee = array_filter(array_diff($currentAssignees, $common));
            $addNewAssignee = array_filter(array_diff($newAssignees, $common));
            $projectAssigneeDetails = array(
                "user_id" => implode(",", $addNewAssignee),
                "project_id" => $request["project_id"],
                "created_by" => $user->id
            );

            if (!empty($addNewAssignee)) {

            	/* Function will add new assignees in project_assignees table */
                $newAssignee = self::assign_project($projectAssigneeDetails);
            }

            if (!empty($deleteAssignee)) {

            	/* Function will delete excluded assignees from project_assignees table */
                $deleteAssignee = self::delete_project_assignee($deleteAssignee, $request["project_id"]);
            }
            return true;
        } else {
            return true;
        }
    }

    /* Function will set assignee of project */
    public static function assign_project($request) {
        try {
            $user = JWTAuth::parseToken()->toUser();
            /* Check if assignees array user_id is empty or not */
            if ($request["user_id"] != null || $request["user_id"] != "") {

                /* Explode array of user id */
                $userIdArray = explode(",", $request["user_id"]);
                $status = false;
                $newAssignee = array();
                for ($i = 0; $i < count($userIdArray); $i++) {
                    $assigneeDetails = array(
                        "project_id" => $request["project_id"],
                        "user_id" => $userIdArray[$i],
                        "created_by" => $user->id
                    );
                    $assignProject = new ProjectAssignees;
                    $assignProject->fill($assigneeDetails);
                    if ($assignProject->save()) {
                        $status = true;
                    } else {
                        $status = false;
                    }
                    $userData = User::find($userIdArray[$i]);
                    array_push($newAssignee, $userData->first_name . " " . $userData->last_name);
                }

                return $status;
            } else {
                return true;
            }
        } catch (Exception $e) {
            $date = Carbon\Carbon::now();
            Log::error($date->toDateTimeString() . ' => Error occured while adding project assignee.');
            $e->message();
        }
    }

    /* Function that will delete project assignee which are removed whlle updating project */
    public static function delete_project_assignee($assigneesID, $projectId) {
        try {
            $user = JWTAuth::parseToken()->toUser();
            $status = false;
            foreach ($assigneesID as $assignee) {
                $deleteAssignee = ProjectAssignees::where("user_id", $assignee)->where("project_id", $projectId)->first();
                if($deleteAssignee->forceDelete()){
                	$status = true;
                } else {
                	$status = false;
                }
            }
            return $status;
        } catch (Exception $e) {
            $date = Carbon\Carbon::now();
            Log::error($date->toDateTimeString() . ' => Error occured while removing project assignee.');
            return $e->getMessage();
        }
    }

    /* Function will add asignees of project, $users contains all the new userid's and $request contaons project details */
    public static function save_project_assigness($users, $request){
        $user = JWTAuth::parseToken()->toUser();
        $userIdArray = explode(",",$users);
        for ($i = 0; $i < count($userIdArray); $i++) {
            $assigneeDetails = array(
                "project_id" => $request["project_id"],
                "user_id" => $userIdArray[$i],
                "created_by" => $user->id
            );
            $assignProject = new ProjectAssignees;
            $assignProject->fill($assigneeDetails);
            if ($assignProject->save()) {
                $status = true;
            } else {
                $status = false;
            }
        }
        return $status;
    }

    /* Function that will create project handle from $projectName tha contains project name */
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
            $projectNameExist = Project::where("handle","=", $projectHandle)->get();
            if (count($projectNameExist) > 0 && !empty($projectNameExist)) {
                $initialValue = $initialValue + 1;

                /* set handle name with incremented value and check again */
                $projectHandle = $projectName . "-" . $initialValue;
            } else {
                $slugStatus = true;
            }
        } while ($slugStatus == false);

        return $projectHandle;
    }

    /* Function that contains all project that are created by user or asssigned to user */
    public static function get_all_user_projects() {
        $user = JWTAuth::parseToken()->toUser();
        $allProjects = array();

        /* Following section of code will get all the projects that are created by login user */
        $getUserProjects = Project::where("created_by",$user->id)->with("statuses")->with("user")->get();
        if(count($getUserProjects->toArray())>0){
            foreach($getUserProjects->toArray() as $value) {
                array_push($allProjects, $value);
            }
        }

        /* Following section of code will get all projects that are assigned to currently login user */
        $getAssignedProjects = ProjectAssignees::where("user_id",$user->id)->get();
        if(count($getAssignedProjects->toArray())>0){
            foreach($getAssignedProjects->toArray() as $value) {
                $project = Project::where("id",$value["project_id"])->with("statuses")->with("user")->with("assignees.user")->first();
                array_push($allProjects, $project->toArray());
            }
        }
        return $allProjects;
    }

    /* Function will get all detailes of project according to handle */
    public static function get_single_project($handle) {
        $user = JWTAuth::parseToken()->toUser();
        $projectDetails = Project::where("handle",$handle)->with("statuses")->with("user")->with("assignees.user")->first();
        if(isset($projectDetails) && !empty($projectDetails)){
            return $projectDetails;
        } else {
            return array();            
        }
    }

    /* Function will delete project and its assigness from project_assignees */
    public static function delete_project($handle){
        $getProject = Project::where("handle",$handle)->first();
        $deleteAssigneeStatus = ProjectAssignees::where("project_id",$getProject->id)->delete();
        if($deleteAssigneeStatus){
            if($getProject->delete()){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }        
    }

}
