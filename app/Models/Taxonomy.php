<?php

namespace App\Models;

use App\Enums\TaxonomyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Taxonomy extends Model
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
        'type',
        'name',
        'slug',
        'desc',
        'sort',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type'  => TaxonomyType::class,
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts(): HasMany
    {
        return $this->hasMany(Post::class)->where('published_at', '<=', Carbon::now());
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    public function scopeType($query, $type): void
    {
        $query->where('type', $type);
    }

    public function scopeSorted($query, $request = []): void
    {
        if (isset($request['order'])) {
            if ($request['order'] == 'total') {
                $hasPost = clone $query;
                if ($hasPost->has('posts')->exists()) {
                    $query->withCount('posts')->orderBy('posts_count', $request['sort']);
                }

                $hasEmployee = clone $query;
                if ($hasEmployee->has('employees')->exists()) {
                    $query->withCount('employees')->orderBy('employees_count', $request['sort']);
                }
            } else {
                $query->orderBy($request['order'], $request['sort']);
            }
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
