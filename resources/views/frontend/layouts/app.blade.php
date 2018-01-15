<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', app_name())</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Laravel 5 Boilerplate')">
        <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles')

        {{ Html::style('css/bootstrap.min.css') }}
        {{ Html::style('css/style.css')  }}
        {{ Html::style('Font-Awesome/css/font-awesome.css') }}
        {{ Html::style('css/sb-admin-2.css') }}

        @yield('after-styles')

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

        
        
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    </head>
        @if (Auth::check())
            <body class="">
            @include('frontend.includes.nav')
        @else
            <body class="login_bg">
        @endif
            @yield('content')
        <!-- Scripts -->
        @yield('before-scripts')
        {!! Html::script(mix('js/frontend.js')) !!}
        @yield('after-scripts')

        @include('includes.partials.ga')
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>