<div class="section-heading">
    <div class="container-fluid">
        <div class="section-heading-2">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="section-heading-2-title text-left">
                        <h2>Search results for "{{ $query }}"
                            @if(!empty($selectedCategory) && isset($searchCategories))
                                @php $selCat = $searchCategories->firstWhere('id', $selectedCategory); @endphp
                                @if($selCat)
                                    <small class="text-muted d-block" style="font-size:14px;">in <strong>{{ $selCat->getLocalizedTitle() }}</strong></small>
                                @endif
                            @endif
                        </h2>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <form action="{{ route('frontend.search') }}" method="GET" class="search-filter-form d-flex align-items-center gap-2 flex-wrap justify-content-end">
                        <select name="category" class="form-control search-filter-select" style="max-width:200px;">
                            <option value="">{{ app()->getLocale() == 'bn' ? 'সব ক্যাটাগরি' : 'All Categories' }}</option>
                            @foreach($searchCategories as $cat)
                                <option value="{{ $cat->id }}" {{ (isset($selectedCategory) && $selectedCategory == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->getLocalizedTitle() }}
                                </option>
                            @endforeach
                        </select>
                        <input type="search" name="q" value="{{ $query }}" class="form-control" style="max-width:220px;" placeholder="{{ app()->getLocale() == 'bn' ? 'পোস্ট খুঁজুন...' : 'Search posts...' }}"/>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-search"></i> {{ app()->getLocale() == 'bn' ? 'খুঁজুন' : 'Search' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
