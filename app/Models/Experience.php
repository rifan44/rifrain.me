<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company', 'role', 'location', 'started_at', 'ended_at',
        'description', 'sort_order', 'is_current',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date:Y-m-d',
            'ended_at' => 'date:Y-m-d',
            'is_current' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
