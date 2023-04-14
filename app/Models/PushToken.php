<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'endpoint',
        'key',
        'auth',
    ];

    public function getTokenNiceNameAttribute(): string
    {
        $url = parse_url($this->endpoint);

        return $url['host'] ?? $this->endpoint;
    }
}
