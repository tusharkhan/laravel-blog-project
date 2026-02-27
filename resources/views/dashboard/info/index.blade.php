@extends('dashboard.master')
@section('title', 'All Infos')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Infos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Infos</li>
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
                            <h3 class="card-title">All Infos</h3>
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
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Submitter</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Links</th>
                                            <th class="text-center">Message</th>
                                            <th class="text-center">Submitted On</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($infos as $info)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + $infos->firstItem() }}</td>
                                            <td>
                                                {{ $info->user ? $info->user->name : $info->name }}
                                                <br><small class="text-muted">{{ $info->user ? $info->user->email : $info->email }}</small>
                                                <br><span class="badge bg-{{ $info->user ? 'success' : 'warning' }}">{{ $info->user ? 'User' : 'Guest' }}</span>
                                            </td>
                                            <td class="text-center">{{ $info->category->title ?? 'N/A' }}</td>
                                            <td>
                                                @foreach ($info->getLinksArray() as $link)
                                                    <a href="{{ trim($link) }}" target="_blank" class="badge bg-info text-white" style="display: inline-block; margin: 2px;">{{ Str::limit(trim($link), 40) }}</a>
                                                @endforeach
                                            </td>
                                            <td>{{ Str::limit($info->message, 80) }}</td>
                                            <td class="text-center">
                                                <div>{{ $info->created_at->format("d M, Y") }}</div>
                                                <div>{{ $info->created_at->format("h:i:s A") }}</div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('dashboard.infos.status', $info->id) }}">
                                                    <span class="badge bg-{{ $info->status ? 'success' : 'warning' }}">{{ $info->status ? 'Reviewed' : 'Pending' }}</span>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('dashboard.infos.destroy', $info->id) }}" method="POST">
                                                    @method("DELETE")
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm deletebtn">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No infos found!</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            {{ $infos->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section("script")
<script src="{{ asset("assets/dashboard/plugins/sweetalert2/sweetalert2.all.js") }}"></script>
<script>
$('.deletebtn').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    Swal.fire({
        title: 'Are you sure?',
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
});
</script>
@endsection

