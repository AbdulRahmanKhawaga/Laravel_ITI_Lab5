<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'original_name', 'hash', 'imageable_id', 'imageable_type'];

    /**
     * Get the parent imageable model (post, user, etc).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}