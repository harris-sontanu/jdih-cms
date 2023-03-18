<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts()
    {
        return $this->hasMany(Post::class)->where('published_at', '<=', Carbon::now());
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSorted($query, $request = [])
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

        return $query;
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('desc', 'LIKE', '%' . $search . '%');
            });
        }
    }
}
