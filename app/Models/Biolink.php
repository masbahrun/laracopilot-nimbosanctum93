<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biolink extends Model
{
    protected $fillable = [
        'domain',
        'title',
        'description',
        'avatar_path',
        'banner_path',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'custom_metatags',
        'views',
        'active'
    ];
    
    protected $casts = [
        'active' => 'boolean',
        'views' => 'integer'
    ];
    
    public function bioItems()
    {
        return $this->hasMany(BioItem::class);
    }
    
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar_path) {
            return asset('storage/' . $this->avatar_path);
        }
        return asset('images/default-avatar.png');
    }
    
    public function getBannerUrlAttribute()
    {
        if ($this->banner_path) {
            return asset('storage/' . $this->banner_path);
        }
        return null;
    }
}