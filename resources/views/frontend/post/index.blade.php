@extends("frontend.master")

@section("title", $post->getLocalizedTitle()." - ".config('app.sitesettings')::first()->site_title)

@section("content")
<section class="post-single">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-12">
                <div class="post-single-image mb-4">
                    <img src="{{ asset("uploads/post/".$post->thumbnail) }}" alt="{{ $post->getLocalizedTitle() }}" class="img-fluid"/>
                </div>
                <div class="post-single-body">
                    <div class="post-single-title">
                        <h1>{{ $post->getLocalizedTitle() }}</h1>
                        <div class="entry-meta p-1">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <p class="post-author-img mb-1">
                                        <span class="text-dark">{{ __('messages.publisher') }}</span> : {{ $post->getLocalizedPublisher() }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="post-author mb-1">
                                        <span class="text-dark">{{ __('messages.reporter') }}</span> : {{ $post->getLocalizedReporter() }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="entry-cat mb-1">
                                        <span class="text-dark">{{ __('messages.location') }}</span> : {{ $post->getLocalizedLocation() }}
                                    </p>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <p class="post-date mb-1"> <span class="text-dark">{{ __('messages.published') }}</span> : {{ $post->getLocalizedCreatedAt() }}</p>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <p class="entry-cat mb-1">
                                        <span class="text-dark">{{ __('messages.links') }} </span> : {!! $post->getLinks() !!}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="post-single-content">
                        {!! $post->getLocalizedContent() !!}
                    </div>
                    <div class="post-single-bottom">

                        <div class="social-media">
                            <p>{{ app()->getLocale() == 'bn' ? 'শেয়ার করুন:' : 'Share on :' }}</p>
                            <ul class="list-inline">
                                <li>
                                    <a href="{{ request()->url() }}"><i class="fab fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="{{ request()->url() }}"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="{{ request()->url() }}"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="{{ request()->url() }}"><i class="fab fa-youtube"></i></a>
                                </li>
                                <li>
                                    <a href="{{ request()->url() }}"><i class="fab fa-pinterest"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- TODO : remove this and add related post -->
{{--                    @include("frontend.post.inc.author")--}}
{{--                    @include("frontend.post.inc.comment")--}}
                    @include("frontend.post.inc.relate_post")
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
