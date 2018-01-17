<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Repositories\Api\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
/**
 * Class UserController.
 */
class UserController extends Controller
{ 

    public function registerUser(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
            'password' => 'required|string|min:6|confirmed'
        ]);
        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            return response()->json(array(
                'status' => FALSE,
                'errors' => $errors
            ));
        } else {
            $userRegisterStatus = UserRepository::registerUser($request->all());
            if($userRegisterStatus["status"]){

                return response()->json($userRegisterStatus,200);

            }
        }
    }

    public function loginUser(Request $request){
        try {
            // validate form data need to move this to request folder
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:4'
            ]);
            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json(array(
                    'status' => FALSE,
                    'errors' => $errors
                ));
            }
            $credentials = $request->only('email', 'password');
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'status' => FALSE,
                        'message' => 'Invalid credentials.'
                    ], 200);
                }
            } catch (JWTException $e) {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Could not create credentials.'
                ], 500);
            }


            return response()->json([
                'status' => TRUE,
                '_JWTtoken' => $token
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => TRUE,
                'error' => $ex->getMessage(),
            ], 200);
        }
    }

    public function logoutUser($token){
        if(JWTAuth::getToken() !== 1){
            if(JWTAuth::invalidate($token) == 1){
                return response()->json([
                    'status' => TRUE,
                    'error' =>"Logout successfull",
                ], 200);
            } else {
                return response()->json([
                    'status' => TRUE,
                    'error' =>"Some error occured, please try again.",
                ], 200);
            }
        }
        
    }

    public function get_user() {
        try {
            $user = JWTAuth::parseToken()->toUser();
            $user = UserRepository::get_single_user($user->id);
            $response = [
                'status' => false
            ];
            if (isset($user) && !empty($user) > 0) {
                $response['status'] = TRUE;
                $response['user'] = $user;
                return response()->json($response, 201);
            } else {
                $response['user'] = [];
                return response()->json($response, 201);
            }
        } catch (\Exception $e) {
            $response['status'] = FALSE;
            $response['errors'] = TRUE;
            $response['message'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function update_user(Request $request) {
        try {
            $user = JWTAuth::parseToken()->toUser();
            
            //call function for update single User
            $updateSingleUser = UserRepository::update_user($request, $user->id);
            if (isset($updateSingleUser) && !empty($updateSingleUser) && count($updateSingleUser->toArray()) > 0) {
                $response['status'] = TRUE;
                $response['user'] = $updateSingleUser->toArray();
                $response['message'] = "Profile Updated Successfully!!";
                return response()->json($response, 201);
            } else {
                $response['status'] = FALSE;
                $response['message'] = "Error while updating user please try again.";
                return response()->json($response, 201);
            }
        } catch (\Exception $e) {
            $response['status'] = FALSE;
            $response['errors'] = TRUE;
            $response['message'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function change_password(Request $request) {
        try {
            $user = JWTAuth::parseToken()->toUser();
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6|confirmed'
            ]);
            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json(array(
                    'status' => FALSE,
                    'errors' => $errors
                ));
            } else {
                $current_password = UserRepository::check_password($request->current_password);
                if (isset($current_password) && !empty($current_password) && $current_password) {
                    $changePassword = UserRepository::change_password($request);
                    if (isset($changePassword) && !empty($changePassword) && $changePassword) {
                        $response['status'] = TRUE;
                        $response['message'] = "Password changed !!";
                        return response()->json($response, 200);
                    } else {
                        $response['status'] = FALSE;
                        $response['message'] = "Error occured while password changed !!";
                        return response()->json($response, 200);
                    }
                } else {
                    $response['status'] = FALSE;
                    $response['message'] = "Entered password not matches with current password.";
                    return response()->json($response, 200);
                }
            }
        } catch (\Exception $e) {
            $response['status'] = FALSE;
            $response['errors'] = TRUE;
            $response['message'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function get_all_user(){
        $users = UserRepository::get_all_user();
        if(count($users) > 0){
            $response['status'] = TRUE;
            $response['errors'] = FALSE;
            $response['users'] = $users;
            return response()->json($response, 200);        
        }
    }
}

