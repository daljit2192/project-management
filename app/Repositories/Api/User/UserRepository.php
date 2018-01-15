<?php

namespace App\Repositories\Api\User;

use App\Models\Access\User\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\Access\User\SocialLogin;
use App\Events\Frontend\Auth\UserConfirmed;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    
    public static function registerUser($request){
        $user = new User();
        $user->first_name = $request["first_name"];
        $user->last_name = $request["last_name"];
        $user->company_name = $request["company_name"];
        $user->email = $request["email"];
        $user->password = bcrypt($request["password"]);
        
        if($user->save()){
            $response['status'] = TRUE;
            $response['user'] = $user->toArray();
            $response['message'] = "Congratulation your account has been created.";
        } else {
            $response['status'] = FALSE;
            $response['message'] = "Some error occured while creating account, please try again.";
        }
        return $response;
    }

    public static function get_single_user($id) {
        $user = User::find($id);
        if (isset($user)>0 && !empty($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public static function update_user($request, $id) {
        //create object of project for update project Detail
        $updateSingleuser = User::find($id);
        $updateSingleuser->fill($request->all());
        if ($updateSingleuser->save()) {
            return $updateSingleuser;
        } else {
            return false;
        }
    }

    public static function check_password($currentPassword){
        $user = JWTAuth::parseToken()->toUser();
        if(Hash::check($currentPassword,$user->password)){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public static function change_password($request){
        $user = JWTAuth::parseToken()->toUser();
        $userRecord = User::find($user->id);
        $userRecord->password = bcrypt($request->password);
        if($userRecord->save()){
            return true;
        }
        else{
            return false;
        }
    }
}
