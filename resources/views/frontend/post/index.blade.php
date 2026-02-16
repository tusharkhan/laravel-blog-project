@extends("frontend.master")

@section("title", $post->getLocalizedTitle()." - ".config('app.sitesettings')::first()->site_title)

@section("content")
<section class="post-single">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-12">
                <div class="post-single-image">
                    <img src="{{ asset("uploads/post/".$post->thumbnail) }}" alt="{{ $post->getLocalizedTitle() }}"/>
                </div>
                <div class="post-single-body">
                    <div class="post-single-title">
                        <h1>{{ $post->getLocalizedTitle() }}</h1>
                        <ul class="entry-meta p-1">
                            <li class="post-author-img">
                                {{ __('messages.publisher') }} : {{ $post->getLocalizedPublisher() }}
                            </li>
                            <li class="post-author">
                                {{ __('messages.reporter') }} : {{ $post->getLocalizedReporter() }}
                            </li>
                            <li class="entry-cat">
                                {{ __('messages.location') }} : {{ $post->getLocalizedLocation() }}
                            </li>
                            <li class="post-date"> {{ __('messages.published') }} : {{ $post->getLocalizedCreatedAt() }}</li>
                        </ul>
                    </div>
                    <div class="post-single-content">
                        {!! $post->getLocalizedContent() !!}
                    </div>
                    <div class="post-single-bottom">
                        @if ($post->getLocalizedPublisher() || $post->getLocalizedReporter() || $post->getLocalizedLocation())
                        <div class="post-meta-info mb-4">
                            @if ($post->getLocalizedPublisher())
                            <p><strong>{{ app()->getLocale() == 'bn' ? 'প্রকাশক:' : 'Publisher:' }}</strong> {{ $post->getLocalizedPublisher() }}</p>
                            @endif
                            @if ($post->getLocalizedReporter())
                            <p><strong>{{ app()->getLocale() == 'bn' ? 'প্রতিবেদক:' : 'Reporter:' }}</strong> {{ $post->getLocalizedReporter() }}</p>
                            @endif
                            @if ($post->getLocalizedLocation())
                            <p><strong>{{ app()->getLocale() == 'bn' ? 'অবস্থান:' : 'Location:' }}</strong> {{ $post->getLocalizedLocation() }}</p>
                            @endif
                        </div>
                        @endif
                        @if ($post->links_count > 0)
                            <div class="post-links ">
                                <p><strong>{{ app()->getLocale() == 'bn' ? 'লিংক:' : 'Links:' }}</strong>
                                    @foreach ($post->links as $link)
                                    <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer">{{ $link->title }}</a>@if (!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>
                        @endif
                        @if ($post->tags_count > 0)
                        <div class="tags">
                            <p>{{ app()->getLocale() == 'bn' ? 'ট্যাগ:' : 'Tags:' }}</p>
                            <ul class="list-inline">
                                @foreach ($post->tags as $tag)
                                <li>
                                    <a href="{{ route("frontend.tag", $str::slug($tag->name)) }}">{{ $tag->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
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
                    @include("frontend.post.inc.author")
                    @include("frontend.post.inc.comment")
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
