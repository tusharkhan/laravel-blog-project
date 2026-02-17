<div class="col-lg-12 oredoo-content mt-10">
    <div class="theiaStickySidebar">
        <div class="section-title">
            <h3>{{ app()->getLocale() == 'bn' ? 'সাম্প্রতিক নিবন্ধ' : 'Recent Articles' }}</h3>
            <hr>
        </div>
        <div class="row">
            @forelse ($recentposts as $recentpost)
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card post-card h-100 border shadow">
                    <div class="post-card-image border-bottom">
                        <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}">
                            <img src="{{ asset("uploads/post/".$recentpost->thumbnail) }}" alt="{{ $recentpost->getLocalizedTitle() }}" class="card-img-top"/>
                        </a>
                    </div>
                    <div class="card-body">
                        <ul class="entry-meta carf-font ">
                            <li class="entry-cat badge badge-info">
                                {{ app()->getLocale() == 'bn' ? "প্রকাশক" : "Publisher" }} : {{ $recentpost->getLocalizedPublisher() }}
                            </li>
                            <li class="post-date badge badge-secondary">
                                {{ app()->getLocale() == 'bn' ? "প্রকাশিত তারিখ:" : "Published" }} : <span class="line"></span>{{ $recentpost->getLocalizedCreatedAt() }}
                            </li>
                        </ul>
                        <h5 class="entry-title card-title">
                            <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}">{{ $recentpost->getLocalizedTitle() }}</a>
                        </h5>
                        <div class="post-btn">
                            <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}" class="btn-read-more">{{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Continue Reading' }} <i class="las la-long-arrow-alt-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">No post found!</div>
            @endforelse
        </div>
        <div class="pagination">
            <div class="pagination-area">
            {{ $recentposts->links("vendor.pagination.custom") }}
            </div>
        </div>
    </div>
</div>
