<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biolink;
use App\Models\BiolinkView;
use App\Models\BioItemClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolinks = Biolink::orderBy('title')->get();
        $selectedBiolinkId = $request->input('biolink_id');
        
        if ($selectedBiolinkId) {
            $biolink = Biolink::findOrFail($selectedBiolinkId);
            $analytics = $this->getBiolinkAnalytics($biolink);
            
            return view('admin.analytics.index', compact('biolinks', 'biolink', 'analytics'));
        }
        
        // Show overview if no specific biolink selected
        $overview = $this->getOverviewAnalytics();
        
        return view('admin.analytics.index', compact('biolinks', 'overview'));
    }
    
    protected function getOverviewAnalytics()
    {
        $totalViews = BiolinkView::count();
        $totalClicks = BioItemClick::count();
        $uniqueVisitors = BiolinkView::distinct('ip_address')->count('ip_address');
        
        // Views by day (last 30 days)
        $viewsByDay = BiolinkView::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as views')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        // Top biolinks by views
        $topBiolinks = Biolink::withCount('biolinkViews')
            ->orderBy('biolink_views_count', 'desc')
            ->limit(5)
            ->get();
        
        // Device breakdown
        $deviceStats = BiolinkView::select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->get();
        
        return compact('totalViews', 'totalClicks', 'uniqueVisitors', 'viewsByDay', 'topBiolinks', 'deviceStats');
    }
    
    protected function getBiolinkAnalytics(Biolink $biolink)
    {
        $totalViews = $biolink->biolinkViews()->count();
        $totalClicks = BioItemClick::where('biolink_id', $biolink->id)->count();
        $uniqueVisitors = $biolink->biolinkViews()->distinct('ip_address')->count('ip_address');
        
        // Views by day (last 30 days)
        $viewsByDay = $biolink->biolinkViews()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Clicks by day (last 30 days)
        $clicksByDay = BioItemClick::where('biolink_id', $biolink->id)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as clicks')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top clicked items
        $topItems = $biolink->bioItems()
            ->withCount('bioItemClicks')
            ->orderBy('bio_item_clicks_count', 'desc')
            ->limit(10)
            ->get();
        
        // Device breakdown
        $deviceStats = $biolink->biolinkViews()
            ->select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->get();
        
        // Browser breakdown
        $browserStats = $biolink->biolinkViews()
            ->select('browser', DB::raw('COUNT(*) as count'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        
        // Recent visitors
        $recentVisitors = $biolink->biolinkViews()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return compact(
            'totalViews',
            'totalClicks',
            'uniqueVisitors',
            'viewsByDay',
            'clicksByDay',
            'topItems',
            'deviceStats',
            'browserStats',
            'recentVisitors'
        );
    }
}