<div class="widget">
    <div class="widget-title">
        <h5>{{ app()->getLocale() == 'bn' ? 'অনুসন্ধান' : 'Search' }}</h5>
    </div>
    <div class="widget-search">
        <form action="{{ route("frontend.search") }}">
            <input type="search" value="{{ request()->route()->getName() == "frontend.search" ? request()->q : "" }}" id="gsearch" name="q" placeholder="{{ app()->getLocale() == 'bn' ? 'খুঁজুন...' : 'Search...' }}">
            <button type="submit" class="btn-submit"><i class="las la-search"></i></button>
        </form>
    </div>
</div>
