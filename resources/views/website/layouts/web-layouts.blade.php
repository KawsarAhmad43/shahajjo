<!DOCTYPE html>
<html lang="en">

<head data-baseurl="{{ URL::to('/') }}">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, content=user-scalable=yes, initial-scale=1.0, maximum-scale=5, minimum-scale=1.0">

    <!-- Favicon Icon -->
    <link rel='icon' type='image/png' sizes='32x32' href="{{ asset('images/n-logo.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ URL::to('/') }}" />

    <!-- Style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>@yield('title')</title>

    <script>
        window.laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseurl: '{{ URL::to('/') }}'
        }
    </script>

</head>

<body>

    @php
        $setting = \App\Models\System\SiteSetting::first();
    @endphp

    <!-- Content -->
    <div id="app">
        @include('website.partials.header')
        @yield('content')
        @include('website.partials.footer')
    </div>

    <!-- Script -->
    <script src="{{ asset('js/web_app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
