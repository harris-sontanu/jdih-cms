<?php

namespace App\Models;

use App\Enums\LegislationDocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type'  => LegislationDocumentType::class,
    ];

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function legislation(): BelongsTo
    {
        return $this->belongsTo(Legislation::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(LegislationDownloadLog::class);
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

    public function scopeOfType($query, $type): void
    {
        $query->where('type', $type);
    }

    public function incrementDownloadCount()
    {
        $count = $this->download;
        $count = $this->download++;
        $this->save();

        return $count;
    }
}
