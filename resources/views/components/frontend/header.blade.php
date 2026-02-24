<header class="header navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <div class="header-area">
            <div class="logo">
                <a href="{{ route("frontend.home") }}">
                    <img src="{{ asset("uploads/logo/".$sitesettings->logo_light) }}" alt="{{ $sitesettings->site_title }}" class="logo-dark"/>
                    <img src="{{ asset("uploads/logo/".$sitesettings->logo_dark) }}" alt="{{ $sitesettings->site_title }}" class="logo-white"/>
                </a>
            </div>
            <div class="header-navbar">
                <nav class="navbar">
                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('frontend.gallery')}}">{{ __('messages.gallery') }}</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="header-right">
{{--                <div class="theme-switch-wrapper">--}}
{{--                    <label class="theme-switch" for="checkbox">--}}
{{--                        <input type="checkbox" id="checkbox" />--}}
{{--                        <span class="slider round ">--}}
{{--                            <i class="lar la-sun icon-light"></i>--}}
{{--                            <i class="lar la-moon icon-dark"></i>--}}
{{--                        </span>--}}
{{--                    </label>--}}
{{--                </div>--}}
                <div class="language-switcher" style="margin-left: 15px; margin-right: 15px;">
                    <div class="dropdown">
                        <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: var(--color-default); border: 1px solid oklch(63.7% .237 25.331); padding: 5px 12px; border-radius: 5px;">
                            @if(app()->getLocale() == 'bn')
                                🇧🇩 বাংলা
                            @else
                                🇬🇧 English
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                            <a class="dropdown-item{{ app()->getLocale() == 'en' ? ' active' : '' }}" href="{{ route('locale.switch', 'en') }}">
                                <i class="las la-check{{ app()->getLocale() != 'en' ? ' invisible' : '' }}"></i> 🇬🇧 English
                            </a>
                            <a class="dropdown-item{{ app()->getLocale() == 'bn' ? ' active' : '' }}" href="{{ route('locale.switch', 'bn') }}">
                                <i class="las la-check{{ app()->getLocale() != 'bn' ? ' invisible' : '' }}"></i> 🇧🇩 বাংলা (Bangla)
                            </a>
                        </div>
                    </div>
                </div>
{{--                <div class="search-icon">--}}
{{--                    <i class="las la-search"></i>--}}
{{--                </div>--}}
                @auth
                <div class="botton-sub">
                    <a href="{{ route("dashboard.home") }}" class="btn-subscribe">Dashboard</a>
                </div>
                @else
                <div class="botton-sub">
                    <a href="{{ route("auth.login") }}" class="btn-subscribe">{{ __('messages.login') }}</a>
                </div>
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </div>
</header>
