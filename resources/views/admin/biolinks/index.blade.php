@extends('layouts.admin')

@section('title', 'Biolinks')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Biolinks</h1>
            </div>
            <div class="col-sm-6">
                <div class="float-right">
                    <a href="{{ route('admin.biolinks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Biolink
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
        @endif
        
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Domain</th>
                            <th>Title</th>
                            <th>Items</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($biolinks as $biolink)
                        <tr>
                            <td>{{ $biolink->id }}</td>
                            <td><code>{{ $biolink->domain }}</code></td>
                            <td>{{ $biolink->title }}</td>
                            <td><span class="badge badge-primary">{{ $biolink->bio_items_count }}</span></td>
                            <td><span class="badge badge-info">{{ number_format($biolink->views) }}</span></td>
                            <td>
                                @if($biolink->active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $biolink->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.biolinks.edit', $biolink->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.biolinks.destroy', $biolink->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this biolink and all its items?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $biolinks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
