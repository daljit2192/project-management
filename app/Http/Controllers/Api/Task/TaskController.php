<?php

namespace App\Http\Controllers\Api\Task;

use App\Models\Access\Task\Task;
use App\Models\Access\Priority\Priority;
use App\Http\Controllers\Controller;
use App\Repositories\Api\Task\TaskRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
/**
 * Class TaskController.
 */
class TaskController extends Controller
{
	
	/* Function which will validate data and pass to repository function to store it in database */
	public function add_task(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:191',
		]);

		if ($validator->fails()) {
			$errors = $validator->getMessageBag()->toArray();
			return response()->json(array(
				'status' => FALSE,
				'errors' => $errors
			));
		} else {
			$addTask = TaskRepository::add_task($request->all());
			print_r($addTask);die;
			if( count($addTask)>0 && isset($addTask)){
				$response['status'] = TRUE;
				$response['tasks'] = $addTask;
				$response['message'] = "Tasks added successfully.";
				return response()->json($response, 201);
			} else {
				$response['status'] = FALSE;
				$response['tasks'] = array();
				$response['message'] = "Error occured while adding task. Please try again.";
				return response()->json($response, 201);
			}
		}

	}

	public function get_priorities(){
		$priority = Priority::all();
		$response['status'] = TRUE;
		$response['priorities'] = $priority->toArray();
		return response()->json($response, 201);
	}

	/* get all tasks of project according to project id */
	public function get_all_project_tasks($project_id){
		$allTasks = Task::where("project_id",$project_id)->with("project")->with("user")->with("statuses")->get();

		/* If any task found then return response with fetched task */
		if(count($allTasks)>0 && isset($allTasks) && !empty($allTasks)){
			$response['status'] = TRUE;
			$response['tasks'] = $allTasks->toArray();
			$response['message'] = "Tasks fetched successfully.";
			return response()->json($response, 201);
		} else {

			/* If no task found, then set status false and return response with message */
			$response['status'] = FALSE;
			$response['message'] = "No task found.";
			return response()->json($response, 201);
		}
	}

	public function get_single_task($taskId){
		$getTaskDetails = TaskRepository::get_single_task($taskId);

		/* If task details found then return response with fetched task */
		if(count($getTaskDetails)>0 && isset($getTaskDetails) && !empty($getTaskDetails)){
			$response['status'] = TRUE;
			$response['task'] = $getTaskDetails;
			$response['message'] = "Tasks fetched successfully.";
			return response()->json($response, 201);
		} else {

			/* If task details not found, then set status false and return response with message */
			$response['status'] = FALSE;
			$response['message'] = "Task details not found.";
			return response()->json($response, 201);
		}	
	}
}

