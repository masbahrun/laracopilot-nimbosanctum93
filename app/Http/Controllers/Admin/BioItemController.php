<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BioItem;
use App\Models\Biolink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BioItemController extends Controller
{
    public function store(Request $request, $biolinkId)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $biolink = Biolink::findOrFail($biolinkId);
        
        $validated = $request->validate([
            'type' => 'required|in:bio,link,text,image',
            'title' => 'nullable|string'
        ]);
        
        $maxOrder = $biolink->bioItems()->max('order') ?? 0;
        
        $bioItem = $biolink->bioItems()->create([
            'type' => $validated['type'],
            'title' => $validated['title'] ?? 'New Item',
            'order' => $maxOrder + 1,
            'active' => true
        ]);
        
        return response()->json(['success' => true, 'item' => $bioItem]);
    }
    
    public function update(Request $request, $biolinkId, $itemId)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $bioItem = BioItem::where('biolink_id', $biolinkId)
            ->where('id', $itemId)
            ->firstOrFail();
        
        $validated = $request->validate([
            'type' => 'required|in:bio,link,text,image',
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'url' => 'nullable|url',
            'active' => 'nullable|boolean'
        ]);
        $validated['active'] = $request->has('active');
        
        $bioItem->update($validated);
        
        return response()->json(['success' => true]);
    }
    
    public function destroy($biolinkId, $itemId)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $bioItem = BioItem::where('biolink_id', $biolinkId)
            ->where('id', $itemId)
            ->firstOrFail();
        
        if ($bioItem->icon_path) {
            Storage::disk('public')->delete($bioItem->icon_path);
        }
        
        $bioItem->delete();
        
        return response()->json(['success' => true]);
    }
    
    public function reorder(Request $request, $biolinkId)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $items = $request->input('items', []);
        
        foreach ($items as $index => $itemId) {
            BioItem::where('id', $itemId)
                ->where('biolink_id', $biolinkId)
                ->update(['order' => $index]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function uploadIcon(Request $request, $itemId)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate(['icon' => 'required|image|max:1024']);
        
        $bioItem = BioItem::findOrFail($itemId);
        
        if ($bioItem->icon_path) {
            Storage::disk('public')->delete($bioItem->icon_path);
        }
        
        $path = $request->file('icon')->store('icons', 'public');
        $bioItem->update(['icon_path' => $path]);
        
        return response()->json(['icon_url' => $bioItem->icon_url]);
    }
}