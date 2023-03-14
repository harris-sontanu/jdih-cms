<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Link extends Model
{
    use HasFactory, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'desc',
        'image_id',
        'url',
        'sort',
        'type',
        'display',
        'user_id',
        'published_at',
    ];

    protected $casts  = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function youtubeId(): Attribute
    {
        $components = parse_url($this->url);
        $v = $components['path'];
        if ( ! empty($components['query'])) {
            $v = '/' . substr($components['query'], 2);
        }

        return Attribute::make(
            get: fn ($value) => $v
        );
    }

    public function youtubeEmbedSource(): Attribute
    {
        $components = parse_url($this->url);
        $v = $components['path'];
        if ( ! empty($components['query'])) {
            $v = '/' . substr($components['query'], 2);
        }

        return Attribute::make(
            get: fn ($value) => 'https://www.youtube.com/embed'.$v
        );
    }

    public function youtubeThumbUrl(): Attribute
    {
        $components = parse_url($this->url);
        $v = $components['path'];
        if ( ! empty($components['query'])) {
            $v = '/' . substr($components['query'], 2);
        }

        $youtubeThumbUrl = '<iframe width="240" height="135" src="https://www.youtube.com/embed'.$v.'" class="rounded" allowfullscreen="" frameborder="0" mozallowfullscreen="" webkitallowfullscreen=""></iframe>';

        return Attribute::make(
            get: fn ($value) => $youtubeThumbUrl
        );
    }

    protected function publicationStatus()
    {
        if (is_null($this->published_at)) {
            $status = 'unpublish';
        } else {
            $status = 'publish';
        }

        return $status;
    }

    public function publicationLabel()
    {
        $status = $this->publicationStatus();
        if ($status === 'unpublish') {
            $publicationLabel = '<span class="text-capitalize text-warning d-block">Tidak Tayang</span>';
        } else if ($status === 'publish')  {
            $publicationLabel = '<span class="text-capitalize text-success d-block">Tayang</span>';
        }

        return $publicationLabel;
    }

    public function publicationBadge()
    {
        $status = $this->publicationStatus();
        if ($status === 'unpublish') {
            $publicationBadge = '<span class="badge bg-warning bg-opacity-20 text-warning">Tidak Tayang</span>';
        } else if ($status === 'publish') {
            $publicationBadge = '<span class="badge bg-success bg-opacity-20 text-success">Tayang</span>';
        }

        return $publicationBadge;
    }

    public function displayBadge()
    {
        if ($this->display === 'popup') {
            $displayBadge = '<span class="badge bg-pink bg-opacity-20 text-pink">Popup</span>';
        } else if ($this->display === 'main') {
            $displayBadge = '<span class="badge bg-primary bg-opacity-20 text-primary">Utama</span>';
        } else if ($this->display === 'aside') {
            $displayBadge = '<span class="badge bg-success bg-opacity-20 text-success">Samping</span>';
        }

        return $displayBadge;
    }

    public function scopeYoutubes($query)
    {
        return $query->where('type', 'youtube');
    }

    public function scopeBanners($query)
    {
        return $query->where('type', 'banner');
    }

    public function scopeJdih($query)
    {
        return $query->where('type', 'jdih');
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeUnpublished($query)
    {
        return $query->whereNull('published_at');
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('desc', 'LIKE', '%' . $search . '%');
        }
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            if ($request['order'] === 'user') {
                $query->join('users', 'users.id', '=', 'links.user_id')
                    ->orderBy('users.name', $request['sort']);
            } else {
                $query->orderBy($request['order'], $request['sort']);
            }
        } else {
            $query->latest();
        }

        return $query;
    }
}
