<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BioItem extends Model
{
    protected $fillable = [
        'biolink_id',
        'type',
        'title',
        'content',
        'url',
        'icon_path',
        'order',
        'active'
    ];
    
    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer'
    ];
    
    public function biolink()
    {
        return $this->belongsTo(Biolink::class);
    }
    
    public function bioItemClicks()
    {
        return $this->hasMany(BioItemClick::class);
    }
    
    public function getIconUrlAttribute()
    {
        if ($this->icon_path) {
            return Storage::disk('public')->url($this->icon_path);
        }
        return null;
    }
}