<div class="widget">
    <div class="widget-title">
        <h5>{{ app()->getLocale() == 'bn' ? 'ট্যাগ' : 'Tags' }}</h5>
    </div>
    <div class="widget-tags">
        <ul class="list-inline">
            @forelse ($tags as $tag)
            <li>
                <a href="{{ route("frontend.tag", $str::slug($tag->name)) }}">{{ $tag->name }}</a>
            </li>
            @empty
            <div>{{ app()->getLocale() == 'bn' ? 'কোনো ট্যাগ পাওয়া যায়নি!' : 'No tag found!' }}</div>
            @endforelse
        </ul>
    </div>
</div>
