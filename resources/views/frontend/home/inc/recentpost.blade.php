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
                                <a href="{{ route("frontend.category", $category->getLocalizedSlug()) }}" class="text-dark">
                                    <i class="las la-folder"></i> {{ $category->getLocalizedTitle() }}
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
                        @include('components.blog-cart', $post)
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
