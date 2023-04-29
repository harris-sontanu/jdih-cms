<?php

namespace App\Models;

use App\Enums\LinkDisplay;
use App\Enums\LinkType;
use App\Models\Traits\HasUser;
use App\Models\Traits\Publication;
use App\Models\Traits\TimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Link extends Model
{
    use HasFactory, TimeFormatter, Publication, HasUser;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'type'  => LinkType::class,
        'display'   => LinkDisplay::class,
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function youtubeParseUrl()
    {
        $url = parse_url($this->url);
        return isset($url['query']) ? '/' . substr($url['query'], 2) : $url['path'];
    }

    public function youtubeId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->youtubeParseUrl()
        );
    }

    public function youtubeEmbedSource(): Attribute
    {
        $components = parse_url($this->url);
        $v = $components['path'];
        if (isset($components['query'])) {
            $v = '/' . substr($components['query'], 2);
        }

        return Attribute::make(
            get: fn ($value) => 'https://www.youtube.com/embed'. $this->youtubeParseUrl()
        );
    }

    public function youtubeThumbUrl(): Attribute
    {
        $youtubeThumbUrl = '<iframe width="240" height="135" src="https://www.youtube.com/embed'.$this->youtubeParseUrl().'" class="rounded" allowfullscreen="" frameborder="0" mozallowfullscreen="" webkitallowfullscreen=""></iframe>';

        return Attribute::make(
            get: fn ($value) => $youtubeThumbUrl
        );
    }

    public function scopeYoutubes($query): void
    {
        $query->where('type', LinkType::YOUTUBE);
    }

    public function scopeBanners($query): void
    {
        $query->where('type', LinkType::BANNER);
    }

    public function scopeJdih($query): void
    {
        $query->where('type', LinkType::JDIH);
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('desc', 'LIKE', '%' . $search . '%');
        }
    }

    public function scopeSorted($query, $request = []): void
    {
        if (isset($request['order'])) {
            match ($request['order']) {
                'user'  => $query->join('users', 'users.id', '=', 'links.user_id')->orderBy('users.name', $request['sort']),
                default => $query->orderBy($request['order'], $request['sort'])
            };
        } else {
            $query->orderBy('sort', 'asc');
        }
    }
}
