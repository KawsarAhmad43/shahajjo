<!DOCTYPE html>
<html>

<head data-baseurl="{{ URL::to('/') }}">
    <meta charset="utf-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- favicon icon start -->
    <link rel='icon' type='image/png' sizes='32x32' href="{{ $siteSetting->favicon }}">
    <!-- favicon icon end -->

    <!-- cache invalidation start -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- cache invalidation end -->

    <!-- csrf token start -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ URL::to('/') }}" />
    <!-- csrf token end -->

    <!-- header script start -->
    <script>
        window.laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseurl: '{{ URL::to('/') }}'
        }
    </script>
    <!-- header script end -->

    <title>{{ config('app.name') }}</title>

    <!-- font start -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="{{ asset('extra/fontawesome-kit.js') }}" crossorigin="anonymous"></script>
    <!-- font end -->

    <!-- style start -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin_layouts.css') }}" rel="stylesheet">
    <!-- style end -->
</head>

<body class="sidebar">

    <!-- vue instance start -->
    <div id="app">
        <app />
    </div>
    <!-- vue instance end -->

    <!-- script start -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin_layouts.js') }}"></script>
    <script src="{{ asset('extra/dist/fast-image-zoom.js') }}"></script>
    <script>
        const destroy = imageZoom({
            selector: `img:not([data-image-zoom-disabled])`,
            containerSelector: null,
            cb: () => {},
            exceed: false,
            padding: 10,
        })
    </script>
    <!-- script end -->
</body>

</html>
