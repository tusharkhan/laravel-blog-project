@extends("frontend.master")

@section("title", __('messages.info')." - ".config('app.sitesettings')::first()->site_title)

@section("content")

{{-- Page Heading --}}
<div class="section-heading">
    <div class="container-fluid">
        <div class="section-heading-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading-2-title">
                        <h1 class="text-danger">{{ __('messages.info') }}</h1>
                        <p class="mt-2">{{ __('messages.info_subtitle') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>

{{-- Info Form --}}
<section class="gallery-filter-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-10 m-auto">

                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p class="m-0">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                @if (session("success"))
                <div class="alert alert-success">
                    <p class="m-0">{{ session("success") }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('frontend.info.store') }}" class="gallery-filter-form" style="display: block;">
                    @csrf

                    {{-- Category --}}
                    <div class="form-group mb-3">
                        <label class="gallery-filter-label" for="category_id">
                            <i class="las la-list"></i> {{ __('messages.category') }}
                        </label>
                        <select name="category_id" id="category_id" class="form-control gallery-filter-input" required>
                            <option value="">-- {{ __('messages.select_category') }} --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->getLocalizedTitle() }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Links --}}
                    <div class="form-group mb-3">
                        <label class="gallery-filter-label" for="links">
                            <i class="las la-link"></i> {{ __('messages.info_links') }}
                        </label>
                        <input
                            type="text"
                            id="links"
                            name="links"
                            class="form-control gallery-filter-input"
                            placeholder="{{ __('messages.info_links_placeholder') }}"
                            value="{{ old('links') }}"
                            required
                        />
                    </div>

                    {{-- Message --}}
                    <div class="form-group mb-3">
                        <label class="gallery-filter-label" for="message">
                            <i class="las la-comment"></i> {{ __('messages.info_message') }}
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            class="form-control gallery-filter-input"
                            rows="5"
                            placeholder="{{ __('messages.info_message_placeholder') }}"
                            required
                        >{{ old('message') }}</textarea>
                    </div>

                    @guest
                    {{-- Name --}}
                    <div class="form-group mb-3">
                        <label class="gallery-filter-label" for="name">
                            <i class="las la-user"></i> {{ __('messages.your_name') }}
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control gallery-filter-input"
                            placeholder="{{ __('messages.your_name') }}"
                            value="{{ old('name') }}"
                            required
                        />
                    </div>

                    {{-- Email --}}
                    <div class="form-group mb-3">
                        <label class="gallery-filter-label" for="email">
                            <i class="las la-envelope"></i> {{ __('messages.your_email') }}
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control gallery-filter-input"
                            placeholder="{{ __('messages.your_email') }}"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>
                    @endguest

                    {{-- Submit --}}
                    <div class="form-group mt-4">
                        <button type="submit" class="btn gallery-btn-filter" style="width: 100%;">
                            <i class="las la-paper-plane"></i> {{ __('messages.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

