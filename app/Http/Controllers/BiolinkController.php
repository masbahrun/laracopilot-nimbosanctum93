<?php

namespace App\Http\Controllers;

use App\Models\Biolink;
use Illuminate\Http\Request;

class BiolinkController extends Controller
{
    public function show(Request $request)
    {
        // Get domain from HTTP_HOST
        $domain = $request->server('HTTP_HOST');
        
        // Remove www. prefix if exists
        $domain = str_replace('www.', '', $domain);
        
        // Find biolink by domain slug
        $biolink = Biolink::where('domain', $domain)
            ->where('active', true)
            ->with(['bioItems' => function($query) {
                $query->where('active', true)->orderBy('order', 'asc');
            }])
            ->first();
        
        if (!$biolink) {
            abort(404, 'Biolink not found for this domain');
        }
        
        // Increment view count
        $biolink->increment('views');
        
        return view('biolink.show', compact('biolink'));
    }
}