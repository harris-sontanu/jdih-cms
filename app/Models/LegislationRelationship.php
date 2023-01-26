<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function legislation()
    {
        return $this->belongsTo(Legislation::class);
    }

    public function relatedTo()
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
