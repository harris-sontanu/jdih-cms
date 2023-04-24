<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ipv4',
        'hits',
        'page',
        'browser',
        'mobile',
        'platform',
        'version',
        'robot',
    ];

    public function scopeCountAll($query): void
    {
        $query->selectRaw('MAX(ipv4)')->groupByRaw('DATE(created_at), ipv4');
    }

    public function scopeCountDaily($query, $subDays = 0): void
    {
        $visitor = $query->selectRaw('MAX(ipv4)');
        $dt = Carbon::now();

        if ($subDays === 0) {
            $visitor->whereDate('created_at', Carbon::today());
        } else if ($subDays === 1) {
            $visitor->whereDate('created_at', Carbon::yesterday());
        } else {
            $visitor->whereDate('created_at', $dt->subDays($subDays));
        }

        $visitor->groupByRaw('DATE(created_at), ipv4');
    }

    public function scopeCountWeekly($query, $subWeeks = 0): void
    {
        $week = Carbon::now()->translatedFormat('W');
        $weekNumber = $week * 1;
        $weekOfYear = $weekNumber <= $subWeeks
            ? 52 + ($weekNumber - $subWeeks)
            : $weekNumber - $subWeeks;

        $query->selectRaw('MAX(ipv4)')->whereRaw('WEEKOFYEAR(created_at) = ' . $weekOfYear)->groupByRaw('DATE(created_at), ipv4');
    }

    public function scopeCountMonthly($query, $subMonths = 0): void
    {
        $dt = Carbon::now()->settings([
            'monthOverflow' => false,
        ]);

        $query->selectRaw('MAX(ipv4)')->whereMonth('created_at', $dt->subMonths($subMonths))->groupByRaw('DATE(created_at), ipv4');
    }
}
