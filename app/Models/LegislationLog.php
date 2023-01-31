<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LegislationLog extends Model
{
    use HasFactory, HelperTrait;

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

    public function legislation()
    {
        return $this->belongsTo(Legislation::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('message', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('legislation', 'title', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request)
    {
        if ($message = $request->message AND $message = $request->message) {
            $query->where(function($q) use ($message) {
                $q->where('message', 'LIKE', '%' . $message . '%')
                ->orWhereRelation('legislation', 'title', 'LIKE', '%' . $message . '%');
            });
        }

        if ($month = $request->month AND $month = $request->month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year = $request->year AND $year = $request->year) {
            $query->whereYear('created_at', $year);
        }

        if ($created_at = $request->created_at AND $created_at = $request->created_at) {
            $query->whereDate('created_at', Carbon::parse($created_at)->format('Y-m-d'));
        }

        if ($user = $request->user AND $user = $request->user) {
            $query->where('user_id', '=', $user);
        }
    }
}

