<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiolinkView extends Model
{
    protected $fillable = [
        'biolink_id',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'device_type',
        'browser',
        'referrer'
    ];
    
    public function biolink()
    {
        return $this->belongsTo(Biolink::class);
    }
}