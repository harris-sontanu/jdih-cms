<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
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
        'name',
        'slug',
        'abbrev',
        'code',
        'desc',
        'sort',
    ];

    public function legislations()
    {
        return $this->hasMany(Legislation::class);
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            if ($request['order'] == 'total') {
                $query->withCount('legislations')->orderBy('legislations_count', $request['sort']);
            } else {
                $query->orderBy($request['order'], $request['sort']);
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        return $query;
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('abbrev', 'LIKE', '%' . $search . '%')
                ->orWhere('desc', 'LIKE', '%' . $search . '%');
            });
        }
    }
}
