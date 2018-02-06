<?php

namespace App\Http\Controllers\Api\Status;

use App\Models\Access\Statuses\Statuses;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
/**
 * Class StatusController.
 */
class StatusController extends Controller
{ 
	/* Function will return all the statses value from database */
    public function get_all_statuses(){
        $statuses = Statuses::all();
        if(count($statuses) > 0){
	        $response['status'] = TRUE;
	        $response['statuses'] = $statuses->toArray();
	        $response['message'] = "All status fetched successfully.";
	        return response()->json($response, 201);
        } else {
        	$response['status'] = FALSE;
        	$response['statuses'] = array();
	        $response['message'] = "No status found.";
	        return response()->json($response, 201);
        }
    }    
}

