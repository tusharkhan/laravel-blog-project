<div class="widget">
    <div class="widget-title">
        <h5>{{ app()->getLocale() == 'bn' ? 'জনপ্রিয় পোস্ট' : 'Popular Posts' }}</h5>
    </div>
    <ul class="widget-popular-posts">
        @forelse ($popularposts as $popularpost)
            <li class="small-post">
                <div class="small-post-image">
                    <a href="{{ route("frontend.post", $popularpost->getLocalizedSlug()) }}">
                        <img src="{{ asset("uploads/post/".$popularpost->thumbnail) }}" alt="{{ $popularpost->getLocalizedTitle() }}"/>
                        <small class="nb">{{ $loop->iteration }}</small>
                    </a>
                </div>
                <div class="small-post-content">
                    <p>
                        <a href="{{ route("frontend.post", $popularpost->getLocalizedSlug()) }}">{{ $popularpost->getLocalizedTitle() }}</a>
                    </p>
                    <small> <span class="slash"></span>{{ $popularpost->created_at->diffForHumans() }}</small>
                </div>
            </li>
        @empty
            <div>{{ app()->getLocale() == 'bn' ? 'কোনো পোস্ট পাওয়া যায়নি!' : 'No post found!' }}</div>
        @endforelse
    </ul>
</div>
