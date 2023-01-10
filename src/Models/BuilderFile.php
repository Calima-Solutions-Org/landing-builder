<?php

namespace Calima\LandingBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BuilderFile extends Model
{
    use HasFactory;

    public function src(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->attributes['src']),
        );
    }
}
