@extends("frontend.master")

@section("title", __('messages.gallery')." - ".config('app.sitesettings')::first()->site_title)

@section("content")

{{-- Page Heading --}}
<div class="section-heading">
    <div class="container-fluid">
        <div class="section-heading-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading-2-title">
                        <h1>{{ __('messages.gallery') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>

{{-- Filter Bar --}}
<section class="gallery-filter-section">
    <div class="container-fluid">
        <form method="GET" action="{{ route('frontend.gallery') }}" class="gallery-filter-form">
            <div class="row align-items-end g-2">
                {{-- Title Search --}}
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <label class="gallery-filter-label" for="title">
                        <i class="las la-search"></i> {{ __('messages.filter_by_title') }}
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control gallery-filter-input"
                        placeholder="{{ __('messages.filter_by_title') }}..."
                        value="{{ request('title') }}"
                    />
                </div>

                {{-- Date Filter --}}
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label class="gallery-filter-label" for="date">
                        <i class="las la-calendar"></i> {{ __('messages.filter_by_date') }}
                    </label>
                    <input type="date" name="date" class="form-control gallery-filter-input" value="{{ request('date') }}">
                </div>

                {{-- Buttons --}}
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="gallery-filter-actions">
                        <button type="submit" class="btn gallery-btn-filter">
                            <i class="las la-filter"></i> {{ __('messages.filter') }}
                        </button>
                        <a href="{{ route('frontend.gallery') }}" class="btn gallery-btn-reset">
                            <i class="las la-redo-alt"></i> {{ __('messages.reset') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- Gallery Items --}}
<section class="gallery-section">
    <div class="container-fluid">
        @forelse ($mediaItems as $item)
        <div class="gallery-card">
            {{-- Title --}}
            <div class="gallery-card-header">
                <h2 class="gallery-card-title">
                    {{ $item->getLocalizedTitle() ?: __('messages.gallery') }}
                </h2>
                {{-- Meta row: date, location, image count --}}
                <div class="gallery-card-meta">
                    <span class="gallery-meta-item">
                        <i class="las la-calendar-alt"></i>
                        {{ $item->getLocalizedCreatedAt() }}
                    </span>
                    @if ($item->getLocalizedLocation())
                    <span class="gallery-meta-item">
                        <i class="las la-map-marker"></i>
                        {{ $item->getLocalizedLocation() }}
                    </span>
                    @endif
                    <span class="gallery-meta-item">
                        <i class="las la-images"></i>
                        {{ $item->files->count() }} {{ __('messages.images') }}
                    </span>
                </div>
                @if ($item->getLocalizedDescription())
                <p class="gallery-card-desc">{{ $item->getLocalizedDescription() }}</p>
                @endif
            </div>

            {{-- Images Grid --}}
            <div class="gallery-images-grid">
                @foreach ($item->files as $index => $file)
                <div class="gallery-image-wrap {{ $index === 0 && $item->files->count() >= 3 ? 'gallery-image-featured' : '' }}"
                     data-src="{{ asset('uploads/media/'.$file->file_name) }}"
                     data-title="{{ $item->getLocalizedTitle() }}"
                     data-index="{{ $index }}"
                     data-media-id="{{ $item->id }}">
                    <img
                        src="{{ asset('uploads/media/'.$file->file_name) }}"
                        alt="{{ $item->getLocalizedTitle() }}"
                        loading="lazy"
                        class="gallery-image"
                    />
                    <div class="gallery-image-overlay">
                        <i class="las la-expand"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if (!$loop->last)
        <div class="gallery-divider"></div>
        @endif

        @empty
        <div class="gallery-empty">
            <i class="las la-image"></i>
            <p>{{ __('messages.no_media_found') }}</p>
        </div>
        @endforelse
    </div>
</section>

{{-- Pagination --}}
@if ($mediaItems->hasPages())
<div class="pagination">
    <div class="container-fluid">
        <div class="pagination-area">
            <div class="row">
                <div class="col-lg-12">
                    {{ $mediaItems->links("vendor.pagination.custom") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Lightbox Modal --}}
<div class="gallery-lightbox" id="galleryLightbox">
    <div class="gallery-lightbox-backdrop"></div>
    <div class="gallery-lightbox-inner">
        <button class="gallery-lightbox-close" id="lightboxClose">
            <i class="las la-times"></i>
        </button>
        <button class="gallery-lightbox-prev" id="lightboxPrev">
            <i class="las la-angle-left"></i>
        </button>
        <button class="gallery-lightbox-next" id="lightboxNext">
            <i class="las la-angle-right"></i>
        </button>
        <div class="gallery-lightbox-img-wrap">
            <img src="" alt="" id="lightboxImg" class="gallery-lightbox-img"/>
        </div>
        <div class="gallery-lightbox-caption" id="lightboxCaption"></div>
    </div>
</div>

@endsection

@section("script")
<script>
(function () {
    // Build per-media image arrays from DOM
    var mediaGroups = {};
    document.querySelectorAll('.gallery-image-wrap').forEach(function (el) {
        var mid = el.dataset.mediaId;
        var idx = parseInt(el.dataset.index);
        if (!mediaGroups[mid]) mediaGroups[mid] = [];
        mediaGroups[mid][idx] = {
            src:   el.dataset.src,
            title: el.dataset.title
        };
    });

    var lightbox    = document.getElementById('galleryLightbox');
    var lightboxImg = document.getElementById('lightboxImg');
    var caption     = document.getElementById('lightboxCaption');
    var currentMid, currentIdx;

    function openLightbox(mid, idx) {
        currentMid = mid;
        currentIdx = idx;
        var item = mediaGroups[mid][idx];
        lightboxImg.src = item.src;
        caption.textContent = item.title;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
        lightboxImg.src = '';
    }

    function navigate(dir) {
        var group = mediaGroups[currentMid];
        currentIdx = (currentIdx + dir + group.length) % group.length;
        var item = group[currentIdx];
        lightboxImg.src = item.src;
        caption.textContent = item.title;
    }

    // Open on image click
    document.querySelectorAll('.gallery-image-wrap').forEach(function (el) {
        el.addEventListener('click', function () {
            openLightbox(el.dataset.mediaId, parseInt(el.dataset.index));
        });
    });

    document.getElementById('lightboxClose').addEventListener('click', closeLightbox);
    document.getElementById('lightboxPrev').addEventListener('click', function () { navigate(-1); });
    document.getElementById('lightboxNext').addEventListener('click', function () { navigate(1); });

    // Close on backdrop click
    document.querySelector('.gallery-lightbox-backdrop').addEventListener('click', closeLightbox);

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape')      closeLightbox();
        if (e.key === 'ArrowLeft')   navigate(-1);
        if (e.key === 'ArrowRight')  navigate(1);
    });
})();
</script>
@endsection

