<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
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
        'desc',
        'sort',
    ];

    public function legislations(): HasMany
    {
        return $this->hasMany(Legislation::class);
    }

    public function scopeSorted($query, $request = []): void
    {
        if (isset($request['order'])) {
            match ($request['order']) {
                'total'     => $query->withCount('legislations')->orderBy('legislations_count', $request['sort']),
                default     => $query->orderBy($request['order'], $request['sort']),
            };
        } else {
            $query->orderBy('name', 'asc');
        }
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('desc', 'LIKE', '%' . $search . '%');
            });
        }
    }
}
