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
            'type' => 'required|in:bio,link,image,text',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'url' => 'nullable|url|max:500',
            'active' => 'boolean'
        ]);
        
        // Get max order
        $maxOrder = $biolink->bioItems()->max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;
        $validated['active'] = $request->has('active') ? true : false;
        
        $bioItem = $biolink->bioItems()->create($validated);
        
        return response()->json([
            'success' => true,
            'bio_item' => $bioItem
        ]);
    }
    
    public function update(Request $request, $biolinkId, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $bioItem = BioItem::where('biolink_id', $biolinkId)->findOrFail($id);
        
        $validated = $request->validate([
            'type' => 'required|in:bio,link,image,text',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'url' => 'nullable|url|max:500',
            'active' => 'boolean'
        ]);
        
        $validated['active'] = $request->has('active') ? true : false;
        
        $bioItem->update($validated);
        
        return response()->json([
            'success' => true,
            'bio_item' => $bioItem
        ]);
    }
    
    public function destroy($biolinkId, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $bioItem = BioItem::where('biolink_id', $biolinkId)->findOrFail($id);
        
        // Delete icon if exists
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
        
        $request->validate(['items' => 'required|array']);
        
        foreach ($request->items as $index => $itemId) {
            BioItem::where('biolink_id', $biolinkId)
                ->where('id', $itemId)
                ->update(['order' => $index + 1]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function uploadIcon(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate(['icon' => 'required|image|max:1024']);
        
        $bioItem = BioItem::findOrFail($id);
        
        // Delete old icon
        if ($bioItem->icon_path) {
            Storage::disk('public')->delete($bioItem->icon_path);
        }
        
        $file = $request->file('icon');
        $fileName = time() . '_icon_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('biolinks/icons', $fileName, 'public');
        
        $bioItem->update(['icon_path' => $filePath]);
        
        return response()->json([
            'success' => true,
            'icon_url' => Storage::disk('public')->url($filePath)
        ]);
    }
}