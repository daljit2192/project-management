<?php

namespace App\Repositories\Api\Task;

use App\Models\Access\Project\Project;
use App\Models\Access\Task\Task;
use App\Models\Access\ProjectAssignees\ProjectAssignees;
use App\Models\Access\TaskAssignees\TaskAssignees;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class TaskRepository.
 */
class TaskRepository extends BaseRepository
{
	/* Function that will insert task data into database */
	public static function add_task($request){
		$user = JWTAuth::parseToken()->toUser();
		$addTask =  new Task;
		$addTask->fill($request);
		$addTask->created_by = $user->id;
		$addTask->tag_name = $request["tags"];
		$addTask->priority_id = $request["priority"];
		if($addTask->save()){
			$assignProjectDetails = array(
				"task_id" => $addTask->id,
				"user_id" => $request["users"],
				"created_by" => $user->id,
			);

			/* AFter saving project call function that will save assignees of project in database */
			$saveAssigneeStatus = self::save_task_assigness($request["users"], $assignProjectDetails);
			if($saveAssigneeStatus){
				return $addTask->toArray();
			} else {
				return array();    
			}
		} else {
			return false;
		}
	}

	/* Function will add asignees of project, $users contains all the new userid's and $request contaons project details */
    public static function save_task_assigness($users, $request){
        $user = JWTAuth::parseToken()->toUser();
        $userIdArray = explode(",",$users);
        for ($i = 0; $i < count($userIdArray); $i++) {
            $assigneeDetails = array(
                "task_id" => $request["task_id"],
                "user_id" => $userIdArray[$i],
                "created_by" => $user->id
            );
            $assignTask = new TaskAssignees;
            $assignTask->fill($assigneeDetails);
            if ($assignTask->save()) {
                $status = true;
            } else {
                $status = false;
            }
        }
        return $status;
    }

	/* Function will details of single task form database */
	public static function get_single_task($taskId){
		$getTaskDetails =  Task::where("id",$taskId)->with("user")->with("statuses")->with("priority")->get();
		if(count($getTaskDetails) > 0 && isset($getTaskDetails) && !empty($getTaskDetails)){
			return $getTaskDetails->toArray();
		} else {
			return array();
		}
	}
}
