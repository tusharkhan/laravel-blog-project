<div class="related-posts-section mt-5 mb-4">
    <div class="related-posts-header mb-4">
        <h3 class="related-posts-title">
            {{ app()->getLocale() == 'bn' ? 'সম্পর্কিত পোস্ট' : 'Related Posts' }}
        </h3>
        <div class="title-underline"></div>
    </div>

    <div class="row">
        @forelse($categoryPosts as $recentpost)
            <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                <div class="card post-card  border-0 shadow-sm transition-hover">
                    <div class="post-card-image position-relative overflow-hidden">
                        <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}" class="card-link-overlay">
                            <img src="{{ asset("uploads/post/".$recentpost->thumbnail) }}" alt="{{ $recentpost->getLocalizedTitle() }}" class="card-img-top img-fluid related-post-img"/>
                        </a>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="entry-meta related-post-meta mb-2">
                            <span class="badge badge-info mr-2">
                                {{ app()->getLocale() == 'bn' ? "প্রকাশক" : "Publisher" }} : {{ $recentpost->getLocalizedPublisher() }}
                            </span>
                            <span class="badge badge-secondary">
                                {{ app()->getLocale() == 'bn' ? "প্রকাশিত তারিখ:" : "Published At" }} : {{ $recentpost->getLocalizedCreatedAt() }}
                            </span>
                        </div>
                        <h5 class="entry-title card-title flex-grow-1">
                            <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}" class="text-dark">{{ $recentpost->getLocalizedTitle() }}</a>
                        </h5>
                        <div class="post-btn mt-auto">
                            <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}" class="btn-read-more text-primary">
                                {{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Continue Reading' }}
                                <i class="las la-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="las la-info-circle"></i>
                    {{ app()->getLocale() == 'bn' ? 'কোনো সম্পর্কিত পোস্ট পাওয়া যায়নি!' : 'No related posts found!' }}
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="pagination">
    <div class="pagination-area">
        {{ $categoryPosts->links("vendor.pagination.custom") }}
    </div>
</div>
