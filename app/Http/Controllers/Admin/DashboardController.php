<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biolink;
use App\Models\BioItem;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $totalBiolinks = Biolink::count();
        $activeBiolinks = Biolink::where('active', true)->count();
        $totalBioItems = BioItem::count();
        $totalViews = Biolink::sum('views');
        
        $recentBiolinks = Biolink::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalBiolinks',
            'activeBiolinks',
            'totalBioItems',
            'totalViews',
            'recentBiolinks'
        ));
    }
}