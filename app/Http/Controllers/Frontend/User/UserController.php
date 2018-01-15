<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Projects\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
/**
 * Class ProfileController.
 */
class UserController extends Controller
{
    
    public function home()
    {
        return view('frontend.user.dashboard');
    } 

    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:191',
                    'last_name' => 'required|string|max:191',
                    'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
                    'password' => 'required|string|min:6|confirmed'
        ]);
        if ($validator->fails()) {
            return view('frontend.auth.register',['message' => $validator->errors()->first(), "status" => 0]);
        } else {
            $userRegisterStatus = UserRepository::registerUser($request->all());
            if($userRegisterStatus["status"]){
                return view('frontend.auth.register',['message' => $userRegisterStatus["message"], "status" => $userRegisterStatus["status"]]);
            }
        }
    }

    public function loginUser(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return view('frontend.auth.login',['message' => $validator->errors()->first(), "status" => 0]);
        } else {
            if (Auth::attempt(['email' => $request["email"], 'password' => $request["password"]])) {
               return redirect()->intended('user/dashboard');
            } else {
               return view('frontend.auth.login',['message' => "Invalid Credentials", "status" => 0]);
            }
        }
    }

    public function showProjects(){
        // ProjectRepository::getAllProjects();
        return view('frontend.project.index');
    }
}
