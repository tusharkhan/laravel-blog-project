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
            <form action="{{ route('frontend.home') }}" method="GET" class="hero-search-form">
                <div class="hero-search-wrapper">
                    <div class="hero-search-category">
                        <select name="category" class="hero-search-select">
                            <option value="">{{ app()->getLocale() == 'bn' ? 'সব ক্যাটাগরি' : 'All Categories' }}</option>
                            @foreach($searchCategories as $cat)
                                <option value="{{ $cat->id }}" {{ (isset($selectedCategory) && $selectedCategory && $selectedCategory->id == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->getLocalizedTitle() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="hero-search-input-wrap">
                        <input type="search" name="q" value="{{ $searchQuery ?? '' }}" class="hero-search-input" placeholder="{{ app()->getLocale() == 'bn' ? 'পোস্ট খুঁজুন...' : 'Search posts...' }}" required/>
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

@if($searchQuery)
{{-- ===== SEARCH RESULTS MODE (grouped by category) ===== --}}
<section class="section-feature-1">
    <div class="container-fluid">

        {{-- Search result info bar --}}
        <div class="search-result-bar d-flex align-items-center justify-content-between flex-wrap mb-4 mt-3 px-2">
            <div>
                <h5 class="mb-0 search-result-heading">
                    <i class="fas fa-search mr-2 text-danger"></i>
                    {{ app()->getLocale() == 'bn' ? '"'.$searchQuery.'" এর ফলাফল' : 'Results for "'.$searchQuery.'"' }}
                    @if($selectedCategory)
                        &nbsp;<span class="badge badge-danger">{{ $selectedCategory->getLocalizedTitle() }}</span>
                    @endif
                </h5>
                <small class="text-muted">
                    {{ $totalFound }} {{ app()->getLocale() == 'bn' ? 'টি পোস্ট পাওয়া গেছে' : 'post(s) found' }}
                </small>
            </div>
            <a href="{{ route('frontend.home') }}" class="btn btn-sm btn-outline-secondary mt-2 mt-md-0">
                <i class="fas fa-times mr-1"></i>{{ app()->getLocale() == 'bn' ? 'ক্লিয়ার করুন' : 'Clear Search' }}
            </a>
        </div>

        <div class="row">
            <div class="col-lg-12 oredoo-content">
                @forelse($searchPostsByCategory as $group)
                    @php $category = $group['category']; $posts = $group['posts']; @endphp
                    <div class="category-section mb-5">
                        {{-- Category Header --}}
                        <div class="category-header mb-4">
                            <div class="category-title-wrapper d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="category-section-title mb-0">
                                        <a href="{{ route('frontend.category', $category->slug) }}" class="text-danger">
                                            <i class="las la-folder"></i> {{ $category->getLocalizedTitle() }}
                                        </a>
                                    </h4>
                                </div>
                                <a href="{{ route('frontend.category', $category->slug) }}" class="btn btn-sm btn-outline-danger">
                                    {{ app()->getLocale() == 'bn' ? 'সব দেখুন' : 'View All' }}
                                </a>
                            </div>
                            <div class="category-divider"></div>
                        </div>

                        {{-- Posts Grid --}}
                        <div class="row">
                            @foreach($posts as $post)
                                @include('components.blog-cart', $post)
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ app()->getLocale() == 'bn' ? 'কোনো পোস্ট পাওয়া যায়নি!' : 'No posts found for your search.' }}
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</section>

@else
{{-- ===== NORMAL CATEGORY LISTING MODE ===== --}}
<section class="section-feature-1">
    <div class="container-fluid">
        <div class="row">
            @include("frontend.home.inc.recentpost")
        </div>
    </div>
</section>
@endif

@endsection
