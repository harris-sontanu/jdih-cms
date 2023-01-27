<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Models\Traits\HelperTrait;

class Post extends Model
{
    use HasFactory, SoftDeletes, HelperTrait;

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
        return $this->belongsTo(User::class);
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function cover()
    {
        return $this->belongsTo(Media::class);
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereRelation('taxonomy', 'type', '=', $type);   
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }
}
