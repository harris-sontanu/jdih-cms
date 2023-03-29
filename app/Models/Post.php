<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use App\Models\Traits\TimeHelper;
use App\Models\Traits\HasUser;

class Post extends Model
{
    use HasFactory, SoftDeletes, TimeHelper, HasUser;
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

    public function author()
    {
        return $this->belongsTo(Employee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function cover()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function galleries()
    {
        return $this->morphMany(Media::class, 'mediaable')->where('id', '<>', $this->cover_id);
    }

    protected function publicationStatus()
    {
        if (is_null($this->published_at)) {
            $status = 'draft';
        } else if (!is_null($this->published_at) and $this->published_at->isFuture()) {
            $status = 'schedule';
        } else if (!is_null($this->deleted_at)) {
            $status = 'trash';
        } else {
            $status = 'publish';
        }

        return $status;
    }

    public function publicationLabel()
    {
        $status = $this->publicationStatus();
        if ($status === 'draft') {
            $publicationLabel = '<span class="text-capitalize text-warning d-block">Draf</span>';
        } else if ($status === 'schedule') {
            $publicationLabel = '<span class="text-capitalize text-info d-block">Terjadwal</span>';
        } else if ($status === 'publish')  {
            $publicationLabel = '<span class="text-capitalize text-success d-block">Terbit</span>';
        } else if ($status === 'trash')  {
            $publicationLabel = '<span class="text-capitalize d-block">Sampah</span>';
        }

        return $publicationLabel;
    }

    public function publicationBadge()
    {
        $status = $this->publicationStatus();
        if ($status === 'draft') {
            $publicationBadge = '<span class="badge bg-warning bg-opacity-20 text-warning">Draf</span>';
        } else if ($status === 'schedule') {
            $publicationBadge = '<span class="badge bg-info bg-opacity-20 text-info">Terjadwal</span>';
        } else if ($status === 'trash') {
            $publicationBadge = '<span class="badge bg-dark bg-opacity-20 text-dark">Sampah</span>';
        } else if ($status === 'publish') {
            $publicationBadge = '<span class="badge bg-success bg-opacity-20 text-success">Terbit</span>';
        }

        return $publicationBadge;
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereRelation('taxonomy', 'type', $type);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeScheduled($query)
    {
        return $query->where('published_at', '>', Carbon::now());
    }

    public function scopeDraft($query)
    {
        return $query->whereNull('published_at');
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('taxonomy', 'name', 'LIKE', '%' . $search . '%');
        }
    }

    public function scopeFilter($query, $request)
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

    public function scopePopular($query)
    {
        return $query->orderBy('view', 'desc');
    }

    public function scopeSorted($query, $request = [])
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

        return $query;
    }

    public function scopeLatestPublished($query)
    {
        return $query->orderBy('published_at', 'desc');
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
