<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Events\Frontend\Auth\UserRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        // Where to redirect users after registering
        $this->redirectTo = route(homeRoute());

        $this->user = $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('frontend.auth.register');
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterRequest $request)
    {
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            $user = $this->user->create($request->only('first_name', 'last_name', 'email', 'password'));
            event(new UserRegistered($user));

            return redirect($this->redirectPath())->withFlashSuccess(
                config('access.users.requires_approval') ?
                    trans('exceptions.frontend.auth.confirmation.created_pending') :
                    trans('exceptions.frontend.auth.confirmation.created_confirm')
            );
        } else {
            access()->login($this->user->create($request->only('first_name', 'last_name', 'email', 'password')));
            event(new UserRegistered(access()->user()));

            return redirect($this->redirectPath());
        }
    }

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
            if($userRegisterStatus){
                return redirect('dashboard');
            }
        }
    }
}
