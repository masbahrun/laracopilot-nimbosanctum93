<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biolink;
use App\Models\BioItem;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $totalBiolinks = Biolink::count();
        $activeBiolinks = Biolink::where('active', true)->count();
        $totalBioItems = BioItem::count();
        $activeBioItems = BioItem::where('active', true)->count();
        
        $recentBiolinks = Biolink::orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalBiolinks',
            'activeBiolinks',
            'totalBioItems',
            'activeBioItems',
            'recentBiolinks'
        ));
    }
}