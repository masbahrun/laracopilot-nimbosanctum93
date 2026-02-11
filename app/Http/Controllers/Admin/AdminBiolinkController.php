<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biolink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBiolinkController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolinks = Biolink::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.biolinks.index', compact('biolinks'));
    }
    
    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        return view('admin.biolinks.create');
    }
    
    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $validated = $request->validate([
            'domain' => 'required|string|unique:biolinks,domain',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'layout' => 'nullable|string',
            'theme_color' => 'nullable|string',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'custom_metatags' => 'nullable|string'
        ]);
        
        $validated['active'] = $request->has('active');
        $biolink = Biolink::create($validated);
        
        return redirect()->route('admin.biolinks.edit', $biolink->id)->with('success', 'Biolink created successfully!');
    }
    
    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolink = Biolink::findOrFail($id);
        return view('admin.biolinks.edit', compact('biolink'));
    }
    
    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolink = Biolink::findOrFail($id);
        
        $validated = $request->validate([
            'domain' => 'required|string|unique:biolinks,domain,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'layout' => 'nullable|string',
            'theme_color' => 'nullable|string',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'custom_metatags' => 'nullable|string'
        ]);
        
        $validated['active'] = $request->has('active');
        $biolink->update($validated);
        
        return redirect()->back()->with('success', 'Biolink updated successfully!');
    }
    
    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolink = Biolink::findOrFail($id);
        
        if ($biolink->avatar_path) {
            Storage::disk('public')->delete($biolink->avatar_path);
        }
        if ($biolink->banner_path) {
            Storage::disk('public')->delete($biolink->banner_path);
        }
        
        $biolink->delete();
        return redirect()->route('admin.biolinks.index')->with('success', 'Biolink deleted successfully!');
    }
    
    public function uploadAvatar(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate(['avatar' => 'required|image|max:2048']);
        
        $biolink = Biolink::findOrFail($id);
        
        if ($biolink->avatar_path) {
            Storage::disk('public')->delete($biolink->avatar_path);
        }
        
        $path = $request->file('avatar')->store('avatars', 'public');
        $biolink->update(['avatar_path' => $path]);
        
        return response()->json(['avatar_url' => $biolink->avatar_url]);
    }
    
    public function uploadBanner(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate(['banner' => 'required|image|max:4096']);
        
        $biolink = Biolink::findOrFail($id);
        
        if ($biolink->banner_path) {
            Storage::disk('public')->delete($biolink->banner_path);
        }
        
        $path = $request->file('banner')->store('banners', 'public');
        $biolink->update(['banner_path' => $path]);
        
        return response()->json(['banner_url' => $biolink->banner_url]);
    }
    
    public function preview($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolink = Biolink::findOrFail($id);
        $bioItems = $biolink->bioItems;
        
        $layout = $biolink->layout ?? 'default';
        $viewPath = 'biolink.layouts.' . $layout;
        
        if (!view()->exists($viewPath)) {
            $viewPath = 'biolink.layouts.default';
        }
        
        return view($viewPath, compact('biolink', 'bioItems'));
    }
}