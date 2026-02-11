<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'layout',
        'theme_color',
        'active'
    ];
    
    protected $casts = [
        'active' => 'boolean'
    ];
    
    public function bioItems()
    {
        return $this->hasMany(BioItem::class)->orderBy('order');
    }
    
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar_path) {
            return Storage::disk('public')->url($this->avatar_path);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->title) . '&size=200&background=667eea&color=fff';
    }
    
    public function getBannerUrlAttribute()
    {
        if ($this->banner_path) {
            return Storage::disk('public')->url($this->banner_path);
        }
        return null;
    }
    
    public static function getAvailableLayouts()
    {
        return [
            'default' => [
                'name' => 'Default',
                'description' => 'Classic centered layout with avatar on top',
                'preview' => '/images/layouts/default.png'
            ],
            'minimal' => [
                'name' => 'Minimal',
                'description' => 'Clean minimal design with subtle shadows',
                'preview' => '/images/layouts/minimal.png'
            ],
            'gradient' => [
                'name' => 'Gradient',
                'description' => 'Modern gradient background with glassmorphism',
                'preview' => '/images/layouts/gradient.png'
            ],
            'card' => [
                'name' => 'Card Style',
                'description' => 'Card-based layout with hover effects',
                'preview' => '/images/layouts/card.png'
            ],
            'social' => [
                'name' => 'Social',
                'description' => 'Social media inspired with large avatar',
                'preview' => '/images/layouts/social.png'
            ]
        ];
    }
}