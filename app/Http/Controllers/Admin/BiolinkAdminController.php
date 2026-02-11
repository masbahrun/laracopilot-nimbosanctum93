<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biolink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiolinkAdminController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolinks = Biolink::withCount('bioItems')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
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
            'domain' => 'required|string|unique:biolinks,domain|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'custom_metatags' => 'nullable|string',
            'active' => 'boolean'
        ]);
        
        $validated['active'] = $request->has('active');
        
        $biolink = Biolink::create($validated);
        
        return redirect()->route('admin.biolinks.edit', $biolink->id)
            ->with('success', 'Biolink created successfully! Now add bio items.');
    }
    
    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolink = Biolink::with(['bioItems' => function($query) {
            $query->orderBy('order', 'asc');
        }])->findOrFail($id);
        
        return view('admin.biolinks.edit', compact('biolink'));
    }
    
    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolink = Biolink::findOrFail($id);
        
        $validated = $request->validate([
            'domain' => 'required|string|max:255|unique:biolinks,domain,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'custom_metatags' => 'nullable|string',
            'active' => 'boolean'
        ]);
        
        $validated['active'] = $request->has('active');
        
        $biolink->update($validated);
        
        return back()->with('success', 'Biolink updated successfully!');
    }
    
    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $biolink = Biolink::findOrFail($id);
        
        // Delete associated files
        if ($biolink->avatar_path) {
            Storage::disk('public')->delete($biolink->avatar_path);
        }
        if ($biolink->banner_path) {
            Storage::disk('public')->delete($biolink->banner_path);
        }
        
        // Delete bio items and their icons
        foreach ($biolink->bioItems as $item) {
            if ($item->icon_path) {
                Storage::disk('public')->delete($item->icon_path);
            }
        }
        
        $biolink->delete();
        
        return redirect()->route('admin.biolinks.index')
            ->with('success', 'Biolink deleted successfully!');
    }
    
    public function uploadAvatar(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate(['avatar' => 'required|image|max:2048']);
        
        $biolink = Biolink::findOrFail($id);
        
        // Delete old avatar
        if ($biolink->avatar_path) {
            Storage::disk('public')->delete($biolink->avatar_path);
        }
        
        $file = $request->file('avatar');
        $fileName = time() . '_avatar_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('biolinks/avatars', $fileName, 'public');
        
        $biolink->update(['avatar_path' => $filePath]);
        
        return response()->json([
            'success' => true,
            'avatar_url' => Storage::disk('public')->url($filePath)
        ]);
    }
    
    public function uploadBanner(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate(['banner' => 'required|image|max:4096']);
        
        $biolink = Biolink::findOrFail($id);
        
        // Delete old banner
        if ($biolink->banner_path) {
            Storage::disk('public')->delete($biolink->banner_path);
        }
        
        $file = $request->file('banner');
        $fileName = time() . '_banner_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('biolinks/banners', $fileName, 'public');
        
        $biolink->update(['banner_path' => $filePath]);
        
        return response()->json([
            'success' => true,
            'banner_url' => Storage::disk('public')->url($filePath)
        ]);
    }
}