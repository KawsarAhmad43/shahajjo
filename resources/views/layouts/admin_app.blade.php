<!DOCTYPE html>
<html>

<head data-baseurl="{{ URL::to('/') }}">
    <meta charset="utf-8">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Favicon Icon -->
    <link rel='icon' type='image/png' sizes='32x32' href="{{ asset('images/favicon.png') }}">

    <!-- no-cache -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ URL::to('/') }}" />

    <script>
        window.laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseurl: '{{ URL::to('/') }}'
        }
    </script>

    <title>{{ config('app.name') }}</title>


    <!-- google font start -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <!-- google font end -->
    <script src="https://kit.fontawesome.com/3f4c7459cb.js" crossorigin="anonymous"></script>

    <!-- css file start -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin_layouts.css') }}" rel="stylesheet">

    <!-- css file end -->
</head>

<body>

    <!-- vue-init -->
    <div id="app">
        <app />
    </div>

    <!-- app-js -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin_layouts.js') }}"></script>

</body>

</html>
