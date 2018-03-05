<?php

namespace App\Repositories\Api\Comment;

use App\Models\Access\User\User;
use App\Models\Access\Comment\Comment;
use App\Models\Access\CommentType\CommentType;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\Api\ProjectAssignees\ProjectAssignees;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\Access\User\SocialLogin;
use App\Events\Frontend\Auth\UserConfirmed;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class CommentRepository.
 */
class CommentRepository extends BaseRepository
{
    
    /* Function will register new user in the database */
    public static function add_comment($request){
        $user = JWTAuth::parseToken()->toUser();
        $comment = new Comment();
        $comment_type = CommentType::where("name",$request["type"])->first();
        $comment->type_id = $comment_type->id;
        $comment->user_id = $user->id;
        $comment->message = $request["message"];
        $comment->source_id = $request["source_id"];

        if($comment->save()){
            $comemntData = Comment::where("id",$comment->id)->with("user")->get();
            return $comemntData->toArray();
        } else {
            return array();
        }
    }

    /* Function will get all comments of task/project */
    public static function get_all_comments($request){
        $user = JWTAuth::parseToken()->toUser();
        $getTypeId = CommentType::where("name",$request["typeId"])->first();
        $getAllComments = Comment::where("type_id",$getTypeId->id)->where("source_id",$request["sourceId"])->with("user")->get();
        if(isset($getAllComments) && !empty($getAllComments) && $getAllComments != null){
            return $getAllComments->toArray();
        } else {
            return array();
        }
    }
}
