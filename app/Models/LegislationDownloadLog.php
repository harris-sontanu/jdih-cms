<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class LegislationDownloadLog extends Model
{
    use HasFactory, Prunable;

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subYear());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ipv4',
        'legislation_document_id',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(LegislationDocument::class);
    }

    public function scopeCountDaily($query, $subDays = 0): void
    {
        $dt = Carbon::now();

        match ($subDays) {
            0   => $query->whereDate('created_at', Carbon::today()),
            1   => $query->whereDate('created_at', Carbon::yesterday()),
            default => $query->whereDate('created_at', $dt->subDays($subDays))
        };
    }
}
