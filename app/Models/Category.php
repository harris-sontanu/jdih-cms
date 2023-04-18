<?php

namespace App\Models;

use App\Models\Traits\HasUser;
use App\Models\Traits\TimeHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, TimeHelper, HasUser;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
        'name',
        'slug',
        'abbrev',
        'code',
        'desc',
        'sort',
        'user_id',
    ];

    public function legislations(): HasMany
    {
        return $this->hasMany(Legislation::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value),
        );
    }

    public function scopeOfType($query, $type): void
    {
        $query->where('type_id', $type);
    }

    public function scopeSorted($query, $request = []): void
    {
        if (isset($request['order'])) {
            if ($request['order'] == 'type') {
                $sort = $request['sort'];
                $query->whereHas('type', function (Builder $q) use ($sort) {
                    $q->orderBy('name', $sort);
                });
            } else if ($request['order'] == 'total') {
                $query->withCount('legislations')->orderBy('legislations_count', $request['sort']);
            } else {
                $query->orderBy($request['order'], $request['sort']);
            }
        } else {
            $query->orderBy('sort', 'asc');
        }
    }

    public function scopeSearch($query, $request): void
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
