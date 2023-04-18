<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Type extends Model
{
    use HasFactory;

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value),
        );
    }
}
