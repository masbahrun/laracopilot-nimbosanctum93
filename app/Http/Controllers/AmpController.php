<?php

namespace App\Http\Controllers;

use App\Models\Biolink;
use Illuminate\Http\Request;

class AmpController extends Controller
{
    public function show($domain)
    {
        $biolink = Biolink::where('domain', $domain)
            ->where('active', true)
            ->firstOrFail();
        
        $bioItems = $biolink->bioItems()->where('active', true)->orderBy('order')->get();
        
        return view('amp.biolink', compact('biolink', 'bioItems'));
    }
}