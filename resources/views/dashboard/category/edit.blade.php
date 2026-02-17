@extends('dashboard.master')
@section('title', 'Edit Category - ' . config('app.name'))

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route("dashboard.home") }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("dashboard.categories.index") }}">All Categories</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                @foreach ($errors->all() as $error)
                                <p class="m-0">{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            @if (session("success"))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                <p class="m-0">{{ session("success") }}</p>
                            </div>
                            @endif
                            <form action="{{ route("dashboard.categories.update", $category->id) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Title (English)</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title in English" value="{{ $category->title }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_bn">Title (Bangla)</label>
                                            <input type="text" class="form-control" id="title_bn" name="title_bn" placeholder="শিরোনাম (বাংলায়)" value="{{ $category->title_bn }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="slug">Slug (English)</label>
                                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug in English" value="{{ $category->slug }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="slug_bn">Slug (Bangla)</label>
                                            <input type="text" class="form-control" id="slug_bn" name="slug_bn" placeholder="স্লাগ (বাংলায়)" value="{{ $category->slug_bn }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description (English)</label>
                                            <textarea id="description" name="description" placeholder="Enter description in English" class="form-control">{{ $category->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="description_bn">Description (Bangla)</label>
                                            <textarea id="description_bn" name="description_bn" placeholder="বিবরণ (বাংলায়)" class="form-control">{{ $category->description_bn }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="1" {{ $category->status ? "selected" : "" }}>Active</option>
                                                <option value="0" {{ !$category->status ? "selected" : "" }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section("style")
<link rel="stylesheet" href="{{ asset("assets/dashboard/plugins/select2/css/select2.min.css") }}"/>
<link rel="stylesheet" href="{{ asset("assets/dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") }}"/>
@endsection

@section("script")
<script src="{{ asset("assets/dashboard/plugins/sweetalert2/sweetalert2.all.js") }}"></script>
<script src="{{ asset("assets/dashboard/plugins/select2/js/select2.full.min.js") }}"></script>
<script src="{{ asset("assets/dashboard/plugins/speakingurl/speakingurl.min.js") }}"></script>
<script src="{{ asset("assets/dashboard/plugins/slugify/slugify.min.js") }}"></script>
<script>
    $(document).ready(function() {
        $('#title').on("input", () => {
            $('#slug').val($.slugify($('#title').val()));
        });
    });
</script>
@endsection
