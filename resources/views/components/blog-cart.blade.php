<div class="col-lg-3 col-md-3 col-sm-12 mb-4">
<div class="card post-card h-100 border shadow transition-hover">
    <div class="post-card-image border-bottom">
        <a href="{{ route("frontend.post", $post->slug) }}">
            <img src="{{ asset("uploads/post/".$post->thumbnail) }}" alt="{{ $post->getLocalizedTitle() }}" class="card-img-top"/>
        </a>
    </div>
    <div class="card-body d-flex flex-column">
        <div class="post-meta mb-2">
                                    <span class="text-muted small">
                                        {{ app()->getLocale() == 'bn' ? "প্রকাশক" : "Publisher" }} : {{ $post->getLocalizedPublisher() }}
                                    </span>
        </div>
        <h5 class="entry-title card-title flex-grow-1">
            <a href="{{ route("frontend.post", $post->slug) }}" class="text-danger">{{ $post->getLocalizedTitle() }}</a>
        </h5>
        <p class="text-muted small ">
            <i class="las la-calendar"></i> {{ $post->getLocalizedCreatedAt() }}
        </p>
        <div class="post-btn mt-auto">
            <a href="{{ route("frontend.post", $post->slug) }}" class="btn-read-more text-danger">
                {{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Continue Reading' }}
                <i class="las la-long-arrow-alt-right"></i>
            </a>
        </div>
    </div>
</div>
</div>
