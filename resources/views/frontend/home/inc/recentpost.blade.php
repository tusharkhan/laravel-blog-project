<div class="col-lg-12 oredoo-content mt-10">
    <div class="theiaStickySidebar">
        <div class="section-title">
            <h3>{{ app()->getLocale() == 'bn' ? 'সাম্প্রতিক নিবন্ধ' : 'Recent Articles' }}</h3>
            <hr>
        </div>

        @forelse ($categories as $category)
            @if($category->posts->count() > 0)
            <div class="category-section mb-5">
                <!-- Category Header -->
                <div class="category-header mb-4">
                    <div class="category-title-wrapper d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="category-section-title mb-0">
                                <a href="{{ route("frontend.category", $category->slug) }}" class="text-dark">
                                    <i class="las la-folder"></i> {{ $category->title }}
                                </a>
                            </h4>
                        </div>
                        <a href="{{ route("frontend.category", $category->slug) }}" class="btn btn-sm btn-outline-dark">
                            {{ app()->getLocale() == 'bn' ? 'সব দেখুন' : 'View All' }}
                        </a>
                    </div>
                    <div class="category-divider"></div>
                </div>

                <!-- Category Posts Grid -->
                <div class="row">
                    @foreach($category->posts as $ind => $post)
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="card post-card h-100 border shadow transition-hover">
                            <div class="post-card-image border-bottom">
                                <a href="{{ route("frontend.post", $post->getLocalizedSlug()) }}">
                                    <img src="{{ asset("uploads/post/".$post->thumbnail) }}" alt="{{ $post->getLocalizedTitle() }}" class="card-img-top"/>
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="post-meta mb-2">
                                    <span class="badge badge-info">
                                        <i class="las la-user"></i> {{ $post->getLocalizedPublisher() }}
                                    </span>
                                </div>
                                <h5 class="entry-title card-title flex-grow-1">
                                    <a href="{{ route("frontend.post", $post->getLocalizedSlug()) }}" class="text-dark">{{ $post->getLocalizedTitle() }}</a>
                                </h5>
                                <p class="text-muted small mb-3">
                                    <i class="las la-calendar"></i> {{ $post->getLocalizedCreatedAt() }}
                                </p>
                                <div class="post-btn mt-auto">
                                    <a href="{{ route("frontend.post", $post->getLocalizedSlug()) }}" class="btn-read-more">
                                        {{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Continue Reading' }}
                                        <i class="las la-long-arrow-alt-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                        @if(++$ind == 4) @break @endif
                    @endforeach
                </div>
            </div>
            @endif
        @empty
        <div class="alert alert-info">
            {{ app()->getLocale() == 'bn' ? 'কোনো পোস্ট পাওয়া যায়নি!' : 'No posts found!' }}
        </div>
        @endforelse
    </div>
</div>
