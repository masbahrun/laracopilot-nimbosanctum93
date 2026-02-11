@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalBiolinks }}</h3>
                        <p>Total Biolinks</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <a href="{{ route('admin.biolinks.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $activeBiolinks }}</h3>
                        <p>Active Biolinks</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalBioItems }}</h3>
                        <p>Total Bio Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-th-list"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $activeBioItems }}</h3>
                        <p>Active Bio Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Biolinks -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Biolinks</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.biolinks.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Create New
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Title</th>
                                    <th>Layout</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBiolinks as $biolink)
                                <tr>
                                    <td><code>{{ $biolink->domain }}</code></td>
                                    <td>{{ $biolink->title }}</td>
                                    <td><span class="badge badge-info">{{ ucfirst($biolink->layout ?? 'default') }}</span></td>
                                    <td>
                                        @if($biolink->active)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $biolink->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.biolinks.edit', $biolink->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="http://{{ $biolink->domain }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>No biolinks yet. Create your first one!</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
