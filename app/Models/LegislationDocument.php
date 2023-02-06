<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LegislationDocument extends Model
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
        'legislation_id',
        'media_id',
        'type',
        'order',
        'download'
    ];

    public function media()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function typeTranslate(): Attribute
    {
        if ($this->type === 'master') {
            $type = 'Batang Tubuh';
        } else if ($this->type === 'abstract') {
            $type = 'Abstrak';
        } else if ($this->type === 'attachment') {
            $type = 'Lampiran';
        } else if ($this->type === 'cover') {
            $type = 'Sampul';
        }

        return Attribute::make(
            get: fn ($value) => $type
        );
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
