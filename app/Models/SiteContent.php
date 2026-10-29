<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = ['key', 'title', 'body', 'metadata'];

    protected function casts(): array
    {
        return ['metadata' => 'array'];
    }
}
