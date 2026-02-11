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
                        <i class="fas fa-plus"></i> Create Biolink
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Title</th>
                            <th>Layout</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($biolinks as $biolink)
                        <tr>
                            <td><code>{{ $biolink->domain }}</code></td>
                            <td>{{ $biolink->title }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($biolink->layout ?? 'default') }}</span></td>
                            <td><span class="badge badge-secondary">{{ $biolink->bioItems->count() }}</span></td>
                            <td>
                                @if($biolink->active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $biolink->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.biolinks.edit', $biolink->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="http://{{ $biolink->domain }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.biolinks.destroy', $biolink->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this biolink?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                <p>No biolinks yet. Create your first one!</p>
                                <a href="{{ route('admin.biolinks.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Create Biolink
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($biolinks->hasPages())
            <div class="card-footer">
                {{ $biolinks->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
