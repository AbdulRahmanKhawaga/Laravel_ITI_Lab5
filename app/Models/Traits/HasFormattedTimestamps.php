<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasFormattedTimestamps
{
    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::parse($value)->format('d M Y h:i a')
        );
    }

    protected function createdAtHuman(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => Carbon::parse($attributes['created_at'])->diffForHumans()
        );
    }
}
