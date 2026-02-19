@extends('dashboard.master')
@section('title', 'All Media')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Media</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Media</li>
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
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h3 class="card-title">All Media</h3>
                            <a href="{{ route("dashboard.media.create") }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Add New Media
                            </a>
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

                            @forelse ($media as $item)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header py-2">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            @if ($item->title)
                                            <strong>{{ $item->title }}</strong>
                                            @if ($item->title_bn)
                                            <span class="text-muted ml-2">/ {{ $item->title_bn }}</span>
                                            @endif
                                            @else
                                            <span class="text-muted">(No title)</span>
                                            @endif
                                            @if ($item->location || $item->location_bn)
                                            <span class="badge badge-info ml-2">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $item->location }}{{ $item->location && $item->location_bn ? ' / ' : '' }}{{ $item->location_bn }}
                                            </span>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center mt-1 mt-sm-0">
                                            <small class="text-muted mr-2"><i class="fas fa-images mr-1"></i>{{ $item->files->count() }} image(s)</small>
                                            <a href="{{ route("dashboard.media.edit", $item->id) }}" class="btn btn-sm btn-info mr-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route("dashboard.media.destroy", $item->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger deletebtn">
                                                    <i class="fas fa-trash"></i> Delete All
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @if ($item->description || $item->description_bn)
                                    <div class="mt-1">
                                        @if ($item->description)
                                        <small class="text-muted">{{ Str::limit($item->description, 120) }}</small>
                                        @endif
                                        @if ($item->description_bn)
                                        <small class="text-muted ml-2">| {{ Str::limit($item->description_bn, 120) }}</small>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body py-2">
                                    <div class="row">
                                        @foreach ($item->files as $file)
                                        <div class="col-md-2 col-sm-3 col-4 mb-2">
                                            <div class="position-relative">
                                                <img class="img-fluid rounded media-thumb" src="{{ asset("uploads/media/".$file->file_name) }}" alt="{{ $item->title }}" title="{{ $item->title }}"/>
                                                <button class="btn btn-xs btn-outline-secondary copybtn mt-1 btn-block" data-clipboard-text="{{ asset("uploads/media/".$file->file_name) }}" title="Copy image link">
                                                    <i class="fas fa-copy mr-1"></i>Copy Link
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @if ($item->files->count() === 0 && $item->file_name)
                                        <div class="col-md-2 col-sm-3 col-4 mb-2">
                                            <img class="img-fluid rounded media-thumb" src="{{ asset("uploads/media/".$item->file_name) }}" alt="{{ $item->title }}"/>
                                            <button class="btn btn-xs btn-outline-secondary copybtn mt-1 btn-block" data-clipboard-text="{{ asset("uploads/media/".$item->file_name) }}">
                                                <i class="fas fa-copy mr-1"></i>Copy Link
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-1"></i> No media found!
                                <a href="{{ route("dashboard.media.create") }}" class="ml-2">Upload your first media</a>
                            </div>
                            @endforelse
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            {{ $media->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section("style")
<style>
    .media-thumb {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section("script")
<script src="{{ asset("assets/dashboard/plugins/sweetalert2/sweetalert2.all.js") }}"></script>
<script src="{{ asset("assets/dashboard/plugins/clipboardjs/clipboard.min.js") }}"></script>
<script>
    var clipboard = new ClipboardJS('.copybtn');
    clipboard.on('success', function(e) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: 'success',
            title: 'Link copied to clipboard!'
        });
    });

    $('.deletebtn').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            text: "This will delete the media and all its images permanently!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection
