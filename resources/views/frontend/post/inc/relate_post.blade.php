<div class="related-posts-section mt-5 mb-4">
    <div class="related-posts-header mb-4">
        <h3 class="related-posts-title">
            {{ app()->getLocale() == 'bn' ? 'সম্পর্কিত পোস্ট' : 'Related Posts' }}
        </h3>
        <div class="title-underline"></div>
    </div>

    <div class="row">
        @forelse($categoryPosts as $post)
            @include('components.blog-cart', $post)
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
