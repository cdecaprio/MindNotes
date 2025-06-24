<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    protected $fillable = [
        'title', 
        'content', 
        'user_id', 
        'folder', 
        'color', 
        'latitude', 
        'longitude'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
