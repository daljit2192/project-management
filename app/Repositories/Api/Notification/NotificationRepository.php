<?php

namespace App\Repositories\Api\Notification;

use App\Models\Access\Project\Project;
use App\Models\Access\Notification\Notification;
use App\Models\Access\Task\Task;
use App\Models\Access\ProjectAssignees\ProjectAssignees;
use App\Models\Access\TaskAssignees\TaskAssignees;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class NotificationRepository.
 */
class NotificationRepository extends BaseRepository
{
	public static function get_all_notifications(){
		$user = JWTAuth::parseToken()->toUser();
		$notifications = Notification::where("user_id",$user->id)->get();
		if(count($notifications) && isset($notifications) && !empty($notifications)){
			return $notifications->toArray();
		} else {
			return array();
		}
	}
}
