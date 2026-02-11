<?php

namespace App\Http\Controllers;

use App\Models\Biolink;
use Illuminate\Http\Request;

class BiolinkController extends Controller
{
    public function show(Request $request)
    {
        $domain = $request->getHost();
        
        $biolink = Biolink::where('domain', $domain)
            ->where('active', true)
            ->firstOrFail();
        
        $bioItems = $biolink->bioItems()->where('active', true)->get();
        
        // Select layout view based on biolink's layout setting
        $layout = $biolink->layout ?? 'default';
        $viewPath = 'biolink.layouts.' . $layout;
        
        // Fallback to default if layout view doesn't exist
        if (!view()->exists($viewPath)) {
            $viewPath = 'biolink.layouts.default';
        }
        
        return view($viewPath, compact('biolink', 'bioItems'));
    }
}