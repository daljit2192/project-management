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
    public function get_all_statuses(){
        $statuses = Statuses::all();
        $response['status'] = TRUE;
        $response['statuses'] = $statuses->toArray();
        $response['message'] = "All status fetched successfully.";
        return response()->json($response, 201);
    }    
}

