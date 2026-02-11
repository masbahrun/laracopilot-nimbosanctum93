<?php

namespace App\Http\Controllers;

use App\Models\Biolink;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        // Get domain from HTTP_HOST
        $domain = $request->server('HTTP_HOST');
        $domain = str_replace('www.', '', $domain);
        
        // Find biolink for this domain
        $biolink = Biolink::where('domain', $domain)
            ->where('active', true)
            ->first();
        
        if (!$biolink) {
            abort(404);
        }
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<lastmod>' . $biolink->updated_at->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';
        $xml .= '</urlset>';
        
        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}