@extends('dashboard.master')
@section('title', 'Edit Media')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Media</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route("dashboard.home") }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("dashboard.media.index") }}">All Media</a></li>
                        <li class="breadcrumb-item active">Edit Media</li>
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
                            <h3 class="card-title">Edit Media</h3>
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

                            <form action="{{ route("dashboard.media.update", $media->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Language Tabs -->
                                        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab">English</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="bangla-tab" data-toggle="tab" href="#bangla" role="tab">বাংলা (Bangla)</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-3" id="languageTabContent">
                                            <!-- English Fields -->
                                            <div class="tab-pane fade show active" id="english" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="title">Title (English)</label>
                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{ old('title', $media->title) }}"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description (English)</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description">{{ old('description', $media->description) }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="location">Location (English)</label>
                                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" value="{{ old('location', $media->location) }}"/>
                                                </div>
                                            </div>

                                            <!-- Bangla Fields -->
                                            <div class="tab-pane fade" id="bangla" role="tabpanel">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> These fields are optional. If left empty, English content will be displayed.
                                                </div>
                                                <div class="form-group">
                                                    <label for="title_bn">শিরোনাম (Title - Bangla)</label>
                                                    <input type="text" class="form-control" id="title_bn" name="title_bn" placeholder="শিরোনাম লিখুন" value="{{ old('title_bn', $media->title_bn) }}"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description_bn">বিবরণ (Description - Bangla)</label>
                                                    <textarea class="form-control" id="description_bn" name="description_bn" rows="3" placeholder="বিবরণ লিখুন">{{ old('description_bn', $media->description_bn) }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="location_bn">অবস্থান (Location - Bangla)</label>
                                                    <input type="text" class="form-control" id="location_bn" name="location_bn" placeholder="অবস্থান লিখুন" value="{{ old('location_bn', $media->location_bn) }}"/>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Add More Images -->
                                        <hr/>
                                        <div class="form-group">
                                            <label for="images">Add More Images</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="images" name="images[]" accept="image/*" multiple/>
                                                <label class="custom-file-label" for="images">Choose images (multiple allowed)</label>
                                            </div>
                                            <small class="form-text text-muted">Select new images to add to this media entry. Accepted formats: jpg, jpeg, png, gif, webp.</small>
                                        </div>

                                        <!-- New Image Previews -->
                                        <div id="imagePreviewContainer" class="row mt-2"></div>
                                    </div>
                                </div>
                                <hr/>
                                <button class="btn btn-success" type="submit"><i class="fas fa-save mr-1"></i> Update Media</button>
                                <a href="{{ route("dashboard.media.index") }}" class="btn btn-secondary ml-2">Cancel</a>
                            </form>

                            <!-- Existing Images -->
                            @if ($media->files->count() > 0)
                            <hr/>
                            <h5>Current Images</h5>
                            <div class="row mt-2">
                                @foreach ($media->files as $file)
                                <div class="col-md-2 col-sm-3 col-4 mb-3">
                                    <div class="card h-100">
                                        <img src="{{ asset("uploads/media/".$file->file_name) }}" class="card-img-top existing-img" alt="media image"/>
                                        <div class="card-body p-1 text-center">
                                            <form action="{{ route("dashboard.media.file.destroy", $file->id) }}" method="POST" class="delete-file-form">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-danger btn-sm btn-block delete-file-btn" title="Delete this image">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
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
    .existing-img {
        height: 120px;
        object-fit: cover;
    }
    #imagePreviewContainer .preview-item {
        position: relative;
        margin-bottom: 10px;
    }
    #imagePreviewContainer img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section("script")
<script src="{{ asset("assets/dashboard/plugins/sweetalert2/sweetalert2.all.js") }}"></script>
<script>
    $(document).ready(function() {
        // Custom file input label update
        $('#images').on('change', function() {
            var files = this.files;
            var label = files.length > 1 ? files.length + ' files selected' : (files[0] ? files[0].name : 'Choose images');
            $(this).next('.custom-file-label').html(label);
            showPreviews(files);
        });

        function showPreviews(files) {
            var container = $('#imagePreviewContainer');
            container.empty();
            if (!files || files.length === 0) return;
            $.each(files, function(i, file) {
                if (!file.type.startsWith('image/')) return;
                var reader = new FileReader();
                reader.onload = function(e) {
                    var col = $('<div class="col-md-2 col-sm-3 col-4 preview-item"></div>');
                    var img = $('<img/>').attr('src', e.target.result).attr('alt', file.name).attr('title', file.name);
                    col.append(img);
                    container.append(col);
                };
                reader.readAsDataURL(file);
            });
        }

        // Delete single image confirmation
        $('.delete-file-btn').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Delete Image?',
                text: "This image will be permanently deleted!",
                icon: 'warning',
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
    });
</script>
@endsection



