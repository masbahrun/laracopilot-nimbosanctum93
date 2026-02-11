@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Analytics</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Biolink Selector -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.analytics.index') }}">
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <label class="mr-2">Select Biolink:</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="biolink_id" class="form-control" onchange="this.form.submit()">
                                        <option value="">-- Overview (All Biolinks) --</option>
                                        @foreach($biolinks as $bl)
                                        <option value="{{ $bl->id }}" {{ request('biolink_id') == $bl->id ? 'selected' : '' }}>
                                            {{ $bl->title }} ({{ $bl->domain }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @if(isset($biolink))
            <!-- Specific Biolink Analytics -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($analytics['totalViews']) }}</h3>
                            <p>Total Views</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($analytics['totalClicks']) }}</h3>
                            <p>Total Clicks</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-mouse-pointer"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($analytics['uniqueVisitors']) }}</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $analytics['totalClicks'] > 0 ? number_format(($analytics['totalClicks'] / $analytics['totalViews']) * 100, 1) : 0 }}%</h3>
                            <p>Click Rate</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Views & Clicks (Last 30 Days)</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="viewsClicksChart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Device Stats -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Devices</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="deviceChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Browser Stats -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Browsers</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="browserChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Clicked Items -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top Clicked Items</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Type</th>
                                        <th>Clicks</th>
                                        <th>URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($analytics['topItems'] as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td><span class="badge badge-primary">{{ ucfirst($item->type) }}</span></td>
                                        <td><strong>{{ number_format($item->bio_item_clicks_count) }}</strong></td>
                                        <td><small>{{ Str::limit($item->url, 50) }}</small></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No click data yet</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Visitors -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Visitors</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>IP Address</th>
                                        <th>Device</th>
                                        <th>Browser</th>
                                        <th>Referrer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($analytics['recentVisitors'] as $visitor)
                                    <tr>
                                        <td>{{ $visitor->created_at->diffForHumans() }}</td>
                                        <td><code>{{ $visitor->ip_address }}</code></td>
                                        <td><span class="badge badge-info">{{ ucfirst($visitor->device_type) }}</span></td>
                                        <td>{{ $visitor->browser ?? 'Unknown' }}</td>
                                        <td><small>{{ $visitor->referrer ? Str::limit($visitor->referrer, 40) : 'Direct' }}</small></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No visitors yet</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        @elseif(isset($overview))
            <!-- Overview Analytics -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($overview['totalViews']) }}</h3>
                            <p>Total Views</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($overview['totalClicks']) }}</h3>
                            <p>Total Clicks</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-mouse-pointer"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($overview['uniqueVisitors']) }}</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Overview Chart -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Views Trend (Last 30 Days)</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="overviewChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Device Distribution</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="overviewDeviceChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Biolinks -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top Biolinks by Views</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Biolink</th>
                                        <th>Domain</th>
                                        <th>Views</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($overview['topBiolinks'] as $bl)
                                    <tr>
                                        <td>{{ $bl->title }}</td>
                                        <td><code>{{ $bl->domain }}</code></td>
                                        <td><strong>{{ number_format($bl->biolink_views_count) }}</strong></td>
                                        <td>
                                            <a href="{{ route('admin.analytics.index', ['biolink_id' => $bl->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-chart-line"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No data yet</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
@if(isset($analytics))
// Views & Clicks Chart
const viewsClicksCtx = document.getElementById('viewsClicksChart').getContext('2d');
const viewsClicksChart = new Chart(viewsClicksCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($analytics['viewsByDay']->pluck('date')) !!},
        datasets: [
            {
                label: 'Views',
                data: {!! json_encode($analytics['viewsByDay']->pluck('views')) !!},
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4
            },
            {
                label: 'Clicks',
                data: {!! json_encode($analytics['clicksByDay']->pluck('clicks')) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Device Chart
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
const deviceChart = new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($analytics['deviceStats']->pluck('device_type')) !!},
        datasets: [{
            data: {!! json_encode($analytics['deviceStats']->pluck('count')) !!},
            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0']
        }]
    }
});

// Browser Chart
const browserCtx = document.getElementById('browserChart').getContext('2d');
const browserChart = new Chart(browserCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($analytics['browserStats']->pluck('browser')) !!},
        datasets: [{
            label: 'Visitors',
            data: {!! json_encode($analytics['browserStats']->pluck('count')) !!},
            backgroundColor: '#4BC0C0'
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
@elseif(isset($overview))
// Overview Chart
const overviewCtx = document.getElementById('overviewChart').getContext('2d');
const overviewChart = new Chart(overviewCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($overview['viewsByDay']->pluck('date')) !!},
        datasets: [{
            label: 'Views',
            data: {!! json_encode($overview['viewsByDay']->pluck('views')) !!},
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});

// Overview Device Chart
const overviewDeviceCtx = document.getElementById('overviewDeviceChart').getContext('2d');
const overviewDeviceChart = new Chart(overviewDeviceCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($overview['deviceStats']->pluck('device_type')) !!},
        datasets: [{
            data: {!! json_encode($overview['deviceStats']->pluck('count')) !!},
            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0']
        }]
    }
});
@endif
</script>
@endsection
