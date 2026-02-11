<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BioItemClick extends Model
{
    protected $fillable = [
        'bio_item_id',
        'biolink_id',
        'ip_address',
        'user_agent',
        'country',
        'device_type'
    ];
    
    public function bioItem()
    {
        return $this->belongsTo(BioItem::class);
    }
    
    public function biolink()
    {
        return $this->belongsTo(Biolink::class);
    }
}