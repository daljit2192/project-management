@extends('frontend.layouts.app')

@section('title', app_name() . ' | Reset Password')

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</h1>
            <!--login section start here-->         
             <div class="account-wall reset_passwqord">
                {{ Form::open(['route' => 'frontend.auth.password.email.post', 'class' => 'form-signin form-horizontal']) }}
                    <strong class="reset_pwd">Forgot your password?</strong>
                    <span class="para">Enter your email address and we will send you instructions on how to reset your password.</span>
                    {{ Form::text('email', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.frontend.email')]) }}
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
                {{ Form::close() }}
            </div>
            <!--login section end here-->              
        </div>
    </div>
   
@endsection