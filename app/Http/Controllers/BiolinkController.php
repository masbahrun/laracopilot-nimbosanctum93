<?php

namespace App\Http\Controllers;

use App\Models\Biolink;
use App\Models\BiolinkView;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class BiolinkController extends Controller
{
    public function show(Request $request)
    {
        $domain = $request->getHost();
        
        $biolink = Biolink::where('domain', $domain)
            ->where('active', true)
            ->firstOrFail();
        
        $bioItems = $biolink->bioItems()->where('active', true)->get();
        
        // Track view
        $this->trackView($request, $biolink);
        
        // Select layout view based on biolink's layout setting
        $layout = $biolink->layout ?? 'default';
        $viewPath = 'biolink.layouts.' . $layout;
        
        // Fallback to default if layout view doesn't exist
        if (!view()->exists($viewPath)) {
            $viewPath = 'biolink.layouts.default';
        }
        
        return view($viewPath, compact('biolink', 'bioItems'));
    }
    
    protected function trackView(Request $request, Biolink $biolink)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());
        
        // Determine device type
        if ($agent->isDesktop()) {
            $deviceType = 'desktop';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        } elseif ($agent->isMobile()) {
            $deviceType = 'mobile';
        } else {
            $deviceType = 'unknown';
        }
        
        BiolinkView::create([
            'biolink_id' => $biolink->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => $deviceType,
            'browser' => $agent->browser(),
            'referrer' => $request->header('referer')
        ]);
    }
}