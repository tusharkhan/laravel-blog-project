@extends("frontend.master")

@section("title", config('app.sitesettings')::first()->site_title." - ".config('app.sitesettings')::first()->tagline)

@section("content")

{{-- Hero Banner Section --}}
@if($sitesettings && $sitesettings->banner_image)
<section class="hero-banner" style="background-image: url('{{ asset('uploads/banner/'.$sitesettings->banner_image) }}');">
@else
<section class="hero-banner hero-banner-no-image">
@endif
    <div class="hero-banner-overlay"></div>
    <div class="container">
        <div class="hero-banner-content text-center">
            @if($sitesettings && $sitesettings->banner_title)
                <h1 class="hero-banner-title">{{ $sitesettings->banner_title }}</h1>
            @else
                <h1 class="hero-banner-title">{{ $sitesettings->site_title ?? 'Our Blog' }}</h1>
            @endif
            @if($sitesettings && $sitesettings->banner_subtitle)
                <p class="hero-banner-subtitle">{{ $sitesettings->banner_subtitle }}</p>
            @endif

            {{-- Search Box --}}
            <form action="{{ route('frontend.search') }}" method="GET" class="hero-search-form">
                <div class="hero-search-wrapper">
                    <div class="hero-search-category">
                        <select name="category" class="hero-search-select">
                            <option value="">{{ app()->getLocale() == 'bn' ? 'সব ক্যাটাগরি' : 'All Categories' }}</option>
                            @foreach($searchCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->getLocalizedTitle() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="hero-search-input-wrap">
                        <input type="search" name="q" class="hero-search-input" placeholder="{{ app()->getLocale() == 'bn' ? 'পোস্ট খুঁজুন...' : 'Search posts...' }}" required/>
                    </div>
                    <button type="submit" class="hero-search-btn">
                        <i class="fas fa-search"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'খুঁজুন' : 'Search' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- @include("frontend.home.inc.featuredpost") --}}
{{-- @include("frontend.home.inc.category") --}}

<section class="section-feature-1">
    <div class="container-fluid">
        <div class="row">
            @include("frontend.home.inc.recentpost")
            {{-- @include("frontend.home.inc.sidebar") --}}
        </div>
    </div>
</section>
@endsection
