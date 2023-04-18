<?php

namespace App\Models;

use App\Enums\SlidePosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class Slide extends Model
{
    use HasFactory;

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sort',
        'header',
        'subheader',
        'desc',
        'position',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'position'  => SlidePosition::class,
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function positionText(): Attribute
    {
        $text = match ($this->position) {
            'top'       => 'atas',
            'center'    => 'tengah',
            'bottom'    => 'bawah'
        };

        return Attribute::make(
            get: fn ($value) => Str::title($text)
        );
    }
}
