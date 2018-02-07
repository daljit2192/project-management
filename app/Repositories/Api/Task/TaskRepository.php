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
			$saveAssigneeStatus = self::assign_task($assignProjectDetails);
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
	public static function assign_task($request){
		$user = JWTAuth::parseToken()->toUser();
		$userIdArray = explode(",",$request["user_id"]);
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
	
	/* Function will details of single task form database */
	public static function get_task_assignees($taskId){
		$getTaskAssignees =  TaskAssignees::where("task_id",$taskId)->with("user")->get();
		if(count($getTaskAssignees) > 0 && isset($getTaskAssignees) && !empty($getTaskAssignees)){
			return $getTaskAssignees->toArray();
		} else {
			return array();
		}
	}

	public static function update_task($request) {
            //create object of task for update task Detail
		$updateSingleTask = Task::find($request["id"]);
		$updateSingleTask->fill($request);
		if ($updateSingleTask->save()) {
			$taskData = Task::where("id", $updateSingleTask->id)->with("user")->first();
			return $taskData->toArray();
		} else {
			return false;
		}
	}

	public static function update_task_assignee($request, $taskId) {
		try {
			$user = JWTAuth::parseToken()->toUser();
            //check if task id present or not
			if (isset($taskId) && $taskId != '') {
				$taskAssignees = TaskAssignees::where("task_id", $taskId)->get();
				$currentAssignees = [];
				foreach ($taskAssignees as $taskAssignee) {
					array_push($currentAssignees, $taskAssignee->user_id);
				}
				$newAssignees = [];
				$newAssignees = explode(",", $request->users);
				$common = array_intersect($currentAssignees, $newAssignees);
				$deleteAssignee = array_filter(array_diff($currentAssignees, $common));
				$addNewAssignee = array_filter(array_diff($newAssignees, $common));

				$taskAssigneeDetails = array(
					"user_id" => implode(",", $addNewAssignee),
					"task_id" => $taskId,
					"created_by" => $user->id
				);

				if (!empty($addNewAssignee)) {
					self::assign_task($taskAssigneeDetails);
				}

				if (!empty($deleteAssignee)) {
					self::delete_task_assignee($deleteAssignee, $taskId);
				}
			}
		} catch (Exception $e) {
			return $e->message();
		}
	}

	public static function delete_task_assignee($assigneesID, $taskId) {
		try {
			$user = JWTAuth::parseToken()->toUser();
			$deleteUsers = array();
			foreach ($assigneesID as $assignee) {

				$userData = User::find($assignee);
				array_push($deleteUsers, $userData->first_name . " " . $userData->last_name);

				$deleteAssignee = TaskAssignees::where("user_id", $assignee)->where("task_id", $taskId)->first();
				$deleteAssignee->forceDelete();
			}

			return true;
		} catch (Exception $e) {
			$date = Carbon\Carbon::now();
			Log::error($date->toDateTimeString() . ' => Error occured while removing project assignee.');
			return $e->getMessage();
		}
	}

}
