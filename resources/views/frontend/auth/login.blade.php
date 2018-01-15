@extends('frontend.layouts.app')

@section('title', app_name() . ' | Login')

@section('content')
    
    <div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">SignIn to Project Management</h1>
            
            <!--login section start here-->         
             <div class="account-wall">
                <img class="profile-img" src="img/photo.png" alt="">
                {{ Form::open(['route' => 'frontend.user.login', 'class' => 'form-signin form-horizontal']) }}
                <!-- <form class="form-signin"> -->

                    {{ Form::email('email', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.frontend.email')]) }}

                    <!-- <input type="text" class="form-control" placeholder="Email" required autofocus> -->
                   {{ Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('validation.attributes.frontend.password')]) }}
                    <button class="btn btn-lg btn-primary btn-block" type="submit"> Sign In</button>
                    @if(isset($message))
                        @if($status)
                            <p style="display: block; color:#74a00d;">{{$message}}</p>
                        @else
                            <p style="display: block; color:red;">{{$message}}</p>
                        @endif
                    @endif
                    <label class="checkbox pull-left">
                        <input type="checkbox" value="remember-me">
                        Keep me signed in
                    </label>
                    <!-- {{ link_to_route('frontend.auth.password.reset', trans('labels.frontend.passwords.forgot_password')) }} -->
                    <a href="{{ URL::to('password/reset') }}" class="pull-right need-help">Forgot Password?</a><span class="clearfix"></span>
                    <a href="{{ URL::to('register') }}" class="new-account">Create an account</a>
                    <a href="#" class="goole-plus">Login With google plus</a>
                    
                {{ Form::close() }}
                <!-- </form> -->
            </div>
            <!--login section end here-->              
        </div>
    </div>
</div>

@endsection

