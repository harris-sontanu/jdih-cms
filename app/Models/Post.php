<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use App\Models\Traits\HasUser;
use App\Models\Traits\Publication;
use App\Models\Traits\TimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Post extends Model
{
    use HasFactory, SoftDeletes, TimeFormatter, Publication, HasUser;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'taxonomy_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'source',
        'cover_id',
        'view',
        'author_id',
        'published_at',
    ];

    protected $casts  = ['published_at' => 'datetime'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function taxonomy(): BelongsTo
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function cover(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function galleries(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable')->where('id', '<>', $this->cover_id);
    }

    public function scopeOfType($query, $type): void
    {
        $query->whereRelation('taxonomy', 'type', $type);
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('taxonomy', 'name', 'LIKE', '%' . $search . '%');
        }
    }

    public function scopeFilter($query, $request): void
    {
        if ($title = $request->title AND $title = $request->title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        if ($body = $request->body AND $body = $request->body) {
            $query->where('body', 'LIKE', '%' . $body . '%');
        }

        if ($taxonomy = $request->taxonomy AND $taxonomy = $request->taxonomy) {
            $query->where('taxonomy_id', $taxonomy);
        }

        if ($created_at = $request->created_at AND $created_at = $request->created_at) {
            $query->whereDate('created_at', Carbon::parse($created_at)->format('Y-m-d'));
        }

        if ($published_at = $request->published_at AND $published_at = $request->published_at) {
            $query->whereDate('published_at', Carbon::parse($published_at)->format('Y-m-d'));
        }

        if ($user = $request->user AND $user = $request->user) {
            $query->where('author_id', $user);
        }
    }

    public function scopeSorted($query, $request = []): void
    {
        if (isset($request['order'])) {
            if ($request['order'] === 'author') {
                $query->join('users', 'users.id', '=', 'news.author_id')
                    ->orderBy('users.name', $request['sort']);
            } else {
                $query->orderBy($request['order'], $request['sort']);
            }
        } else {
            $query->latest();
        }
    }

    public function incrementViewCount()
    {
        $count = $this->view;
        if (!request()->cookie($this->slug)) {
            Cookie::queue($this->slug, request()->ip(), 1440);
            $count = $this->view++;
            $this->save();
        }

        return $count;
    }
}
