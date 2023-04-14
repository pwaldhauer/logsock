<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level',
        'topic',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    const MAP = [
        1 => 'trace',
        2 => 'debug',
        3 => 'info',
        4 => 'notice',
        5 => 'warning',
        6 => 'error',
        7 => 'critical',
        8 => 'alert',
        9 => 'emergency',
    ];

    public function levelLabel()
    {
       return self::MAP[$this->level];
    }
}
