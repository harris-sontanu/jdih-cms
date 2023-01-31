<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
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
        'document_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function scopeCountDaily($query, $subDays = 0)
    {
        $dt = Carbon::now();

        if ($subDays === 0) {
            $query->whereDate('created_at', Carbon::today());
        } else if ($subDays === 1) {
            $query->whereDate('created_at', Carbon::yesterday());
        } else {
            $query->whereDate('created_at', $dt->subDays($subDays));
        }

        return $query;
    }
}
