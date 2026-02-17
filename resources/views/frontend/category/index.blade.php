@extends("frontend.master")

@section("title", $category->title." - ".config('app.sitesettings')::first()->site_title)

@section("content")
<div class="section-heading " >
    <div class="container-fluid">
         <div class="section-heading-2">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="section-heading-2-title">
                         <h1>{{ $category->title }}</h1>
                         <p class="links"><a href="{{ route("frontend.home") }}">Home <i class="las la-angle-right"></i></a> {{ $category->title }}</p>
                     </div>
                 </div>
             </div>
         </div>
        <hr>
     </div>
</div>
<section class="blog-layout-2">
    <div class="container-fluid">
        <div class="row">
            @forelse ($posts as $post)
                    @include('components.blog-cart', $post)
            @empty
                <div>{{ app()->getLocale() == 'bn' ? 'কোনো পোস্ট পাওয়া যায়নি!' : 'No post found!' }}</div>
            @endforelse
        </div>
    </div>
</section>
<div class="pagination">
    <div class="container-fluid">
        <div class="pagination-area">
            <div class="row">
                <div class="col-lg-12">
                    {{ $posts->links("vendor.pagination.custom") }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
