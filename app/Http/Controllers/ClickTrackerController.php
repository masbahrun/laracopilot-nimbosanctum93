<?php

namespace App\Http\Controllers;

use App\Models\BioItem;
use App\Models\BioItemClick;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ClickTrackerController extends Controller
{
    public function track(Request $request, $itemId)
    {
        $bioItem = BioItem::findOrFail($itemId);
        
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
        
        BioItemClick::create([
            'bio_item_id' => $bioItem->id,
            'biolink_id' => $bioItem->biolink_id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => $deviceType
        ]);
        
        return redirect($bioItem->url);
    }
}