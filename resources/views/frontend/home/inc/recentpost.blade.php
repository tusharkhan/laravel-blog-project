<div class="col-lg-8 oredoo-content">
    <div class="theiaStickySidebar">
        <div class="section-title">
            <h3>{{ app()->getLocale() == 'bn' ? 'সাম্প্রতিক নিবন্ধ' : 'Recent Articles' }}</h3>
            <p>{{ app()->getLocale() == 'bn' ? 'জীবনের সমস্ত বিষয়ে সবচেয়ে উল্লেখযোগ্য প্রবন্ধগুলি আবিষ্কার করুন।' : 'Discover the most outstanding articles in all topics of life.' }}</p>
        </div>
        @forelse ($recentposts as $recentpost)
        <div class="post-list post-list-style4">
            <div class="post-list-image">
                <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}">
                    <img src="{{ asset("uploads/post/".$recentpost->thumbnail) }}" alt="{{ $recentpost->getLocalizedTitle() }}"/>
                </a>
            </div>
            <div class="post-list-content">
                <ul class="entry-meta">
                    <li class="entry-cat">
                        <a href="{{ route("frontend.category", $recentpost->category->slug) }}" class="category-style-1">{{ $recentpost->category->title }}</a>
                    </li>
                    <li class="post-date"> <span class="line"></span>{{ $recentpost->created_at->format("F d, Y") }}</li>
                </ul>
                <h5 class="entry-title">
                    <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}">{{ $recentpost->getLocalizedTitle() }}</a>
                </h5>

                <div class="post-btn">
                    <a href="{{ route("frontend.post", $recentpost->getLocalizedSlug()) }}" class="btn-read-more">{{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Continue Reading' }} <i class="las la-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
        @empty
        <div>No post found!</div>
        @endforelse
        <div class="pagination">
            <div class="pagination-area">
            {{ $recentposts->links("vendor.pagination.custom") }}
            </div>
        </div>
    </div>
</div>
