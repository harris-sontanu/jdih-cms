<?php

namespace App\Models;

use App\Enums\LawRelationshipStatus;
use App\Enums\LegislationRelationshipType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegislationRelationship extends Model
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
        'related_to',
        'type',
        'status',
        'note'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type'  => LegislationRelationshipType::class,
        'status'=> LawRelationshipStatus::class,
    ];

    public function legislation(): BelongsTo
    {
        return $this->belongsTo(Legislation::class);
    }

    public function relatedTo(): BelongsTo
    {
        return $this->belongsTo(Legislation::class, 'related_to', 'id');
    }

    public function statusPhrase(): Attribute
    {
        $statusPhrase = $this->status;
        if ($this->status == 'diubah' OR $this->status == 'dicabut'){
            $statusPhrase .= ' dengan';
        }

        return Attribute::make(
            get: fn ($value) => $statusPhrase
        );
    }
}
