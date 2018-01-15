@extends('frontend.layouts.app')

@section('title', app_name() . ' | Register')

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">{{ trans('labels.frontend.auth.register_box_title') }}</h1>
            <!--login section start here-->         
             <div class="account-wall">
                <img class="profile-img" src="img/photo.png" alt="">
                 {{ Form::open(['route' => 'frontend.user.register', 'class' => 'form-signin form-horizontal']) }}
                    {{ Form::text('first_name', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.frontend.first_name')]) }}

                    {{ Form::text('last_name', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => trans('validation.attributes.frontend.last_name')]) }}


                    {{ Form::email('email', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => trans('validation.attributes.frontend.email')]) }}

                    {{ Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('validation.attributes.frontend.password')]) }}

                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('validation.attributes.frontend.password_confirmation')]) }}

                    <button class="btn btn-lg btn-primary btn-block" type="submit"> Sign Up For Free </button>
                    @if(isset($message))
                        @if($status)
                            <p style="display: block; color:#74a00d;">{{$message}}</p>
                        @else
                            <p style="display: block; color:red;">{{$message}}</p>
                        @endif
                    @endif
                     <a href="#" class="goole-plus">Login With google plus</a>
                </form>
            </div>
            <!--login section end here-->              
        </div>
    </div>

    
@endsection

@section('after-scripts')
    @if (config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
@endsection