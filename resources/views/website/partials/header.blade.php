<!-- header part start -->
<header class="d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="logo text-center mt-5">
                    <a href="{{ url('/') }}">
                        <img src="{{ $setting->logo }}" alt="logo" height="30">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header part end -->
<!-- navbar part start -->
<nav class="navbar navbar-expand-lg d-none d-lg-block sticky-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                @foreach (WebsiteMenus::menus() ?? [] as $menu)
                    <li class="nav-item">
                        @if ($menu['type'] == 'external_link')
                            <a class="nav-link" href="{!! route($menu['url']) !!}">{!! $menu['title'] ?? '' !!}</a>
                        @elseif ($menu['type'] == 'external_link' && $menu['params'] != null)
                            <a class="nav-link" href="{!! route($menu['url'], $menu['params']) !!}">{!! $menu['title'] ?? '' !!}</a>
                        @elseif ($menu['type'] == 'content' && $menu['params'] != null)
                            <a class="nav-link" href="{!! route('content.details', $menu['params']) !!}">{!! $menu['title'] ?? '' !!}</a>
                        @elseif ($menu['type'] == 'content')
                            <a class="nav-link" href="{!! route('content.details', $menu['slug']) !!}">{!! $menu['title'] ?? '' !!}</a>
                        @elseif ($menu['type'] == 'outside_website')
                            <a class="nav-link" target="_blank"
                                href="{!! $menu['url'] !!}">{!! $menu['title'] ?? '' !!}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
<!-- navbar part end -->
<!-- mobile menu part start -->
<section class="mobile-menu d-block d-lg-none sticky-top">
    <div class="mobile-topbar">
        <div class="container">
            <div class="topbar-main d-flex justify-content-between align-items-center">
                <div class="logo">
                    <img src="{{ asset('website/images/logo.png') }}" alt="Tour-Logo-PNG" class="img-fluid"
                        width="180">
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu-main">
        <div class="close-m-menu"><i class="fas fa-times"></i></div>
        <div class="menu-body">
            <div class="menu-list pt-0">
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('home') }} ">Home</a>
                    </li>
                    @foreach (WebsiteMenus::menus() ?? [] as $menu)
                        <li class="nav-item">
                            @if ($menu['type'] == 'external_link')
                                <a class="nav-link" href="{!! route($menu['url']) !!}">{!! $menu['title'] ?? '' !!}</a>
                            @elseif ($menu['type'] == 'external_link' && $menu['params'] != null)
                                <a class="nav-link" href="{!! route($menu['url'], $menu['params']) !!}">{!! $menu['title'] ?? '' !!}</a>
                            @elseif ($menu['type'] == 'content' && $menu['params'] != null)
                                <a class="nav-link" href="{!! route('content.details', $menu['params']) !!}">{!! $menu['title'] ?? '' !!}</a>
                            @elseif ($menu['type'] == 'content')
                                <a class="nav-link" href="{!! route('content.details', $menu['slug']) !!}">{!! $menu['title'] ?? '' !!}</a>
                            @elseif ($menu['type'] == 'outside_website')
                                <a class="nav-link" target="_blank"
                                    href="{!! $menu['url'] !!}">{!! $menu['title'] ?? '' !!}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- mobile menu part end -->
