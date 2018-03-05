<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Repositories\Api\Comment\CommentRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
/**
 * Class UserController.
 */
class CommentController extends Controller
{ 

    /* Function will add new comment */
    public function add_comment(Request $request){

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:191',
        ]);
        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            return response()->json(array(
                'status' => FALSE,
                'errors' => $errors
            ));
        } else {
            $commentAddStatus = CommentRepository::add_comment($request->all());
            if(isset($commentAddStatus) && count($commentAddStatus) > 0 && !empty($commentAddStatus)){
                $response['status'] = TRUE;
                $response['comment'] = $commentAddStatus;
                $response['message'] = "Comment added successfully.";
                return response()->json($response, 201);
            } else {
                $response['status'] = FALSE;
                $response['message'] = "Error occured while posting comment, please try again.";
                return response()->json($response, 201);
            }
            
        }
    }

    /* Get all comments of particular source_id and type_id */
    public function get_all_comments(Request $request){
        if(isset($request["sourceId"]) && isset($request["typeId"])){
            $getComments = CommentRepository::get_all_comments($request);

            if(isset($getComments) && count($getComments) > 0 && !empty($getComments)){
                $response['status'] = TRUE;
                $response['comments'] = $getComments;
                $response['message'] = "Comments fetched successfully.";
                return response()->json($response, 201);
            } else {
                $response['status'] = FALSE;
                $response['message'] = "No comment found.";
                return response()->json($response, 201);
            }
        }
    }

}

