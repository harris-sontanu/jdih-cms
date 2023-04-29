<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use App\Models\Traits\TimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class LegislationLog extends Model
{
    use HasFactory, TimeFormatter, HasUser;

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'legislation_id',
        'user_id',
        'message',
    ];

    public function legislation(): BelongsTo
    {
        return $this->belongsTo(Legislation::class)->withTrashed();
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('message', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('legislation', 'title', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request): void
    {
        if ($request->has('message')) {
            $message = $request->message;
            $query->where(function($q) use ($message) {
                $q->where('message', 'LIKE', '%' . $message . '%')
                ->orWhereRelation('legislation', 'title', 'LIKE', '%' . $message . '%');
            });
        }

        if ($request->has('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->has('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->has('created_at')) {
            $query->whereDate('created_at', Carbon::parse($request->created_at)->format('Y-m-d'));
        }

        if ($request->has('user')) {
            $query->where('user_id', $request->user);
        }
    }
}

