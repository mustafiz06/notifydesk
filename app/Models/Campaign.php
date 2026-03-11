<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'selected_contacts' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getChannelIconAttribute()
    {
        return [
            'email' => 'fas fa-envelope',
            'sms' => 'fas fa-sms',
            'whatsapp' => 'fab fa-whatsapp',
        ][$this->channel] ?? 'fas fa-bullhorn';
    }

    public function getChannelColorAttribute()
    {
        return [
            'email' => 'primary',
            'sms' => 'warning',
            'whatsapp' => 'success',
        ][$this->channel] ?? 'secondary';
    }
}
