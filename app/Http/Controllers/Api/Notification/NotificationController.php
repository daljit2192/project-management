<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Repositories\Api\Comment\CommentRepository;
use App\Repositories\Api\Notification\NotificationRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
/**
 * Class NotificationController.
 */
class NotificationController extends Controller
{ 
    public function get_all_notifications(){
        $notifications = NotificationRepository::get_all_notifications();
        if(count($notifications) > 0 && isset($notifications) && !empty($notifications)){
            // echo "<pre>";print_r($notifications);die;
            $response['status'] = TRUE;
            $response['notifications'] = $notifications;
            return response()->json($response, 200);
        } else {
            $response['status'] = FALSE;
            return response()->json($response, 200);
        }
    }
}

