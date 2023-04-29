<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
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
        'position',
        'picture',
        'nip',
        'rank',
        'phone',
        'email',
        'address',
        'city',
        'district',
        'regency',
        'province',
        'bio',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'youtube',
        'sort',
    ];

    public function taxonomies(): BelongsToMany
    {
        return $this->belongsToMany(Taxonomy::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function pictureUrl(): Attribute
    {
        $pictureUrl = asset('assets/admin/images/placeholders/user.png');
        if (!empty($this->picture)) {
            if (Storage::disk('public')->exists($this->picture)) $pictureUrl = Storage::url($this->picture);
        }

        return Attribute::make(
            get: fn ($value) => $pictureUrl
        );
    }

    public function fullAddress(): Attribute
    {
        $fullAddress = $this->address;
        if ($this->address) {
            if ($this->city) {
                $fullAddress .= ', ' . $this->city;
            }

            if ($this->district) {
                $fullAddress .= ', ' . $this->district;
            }

            if ($this->regency) {
                $fullAddress .= ', ' . $this->regency;
            }

            if ($this->province) {
                $fullAddress .= ', ' . $this->province;
            }
        }

        return Attribute::make(
            get: fn ($value) => $fullAddress
        );
    }

    public function pictureThumbUrl(): Attribute
    {
        $pictureThumbUrl = asset('assets/admin/images/placeholders/user.png');
        if (!empty($this->picture)) {
            $ext = substr(strchr($this->picture, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_sq.{$ext}", $this->picture);
            if (Storage::disk('public')->exists($thumbnail)) $pictureThumbUrl = Storage::url($thumbnail);
        }

        return Attribute::make(
            get: fn ($value) => $pictureThumbUrl
        );
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('position', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request): void
    {   
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->has('position')) {
            $query->where('position', 'LIKE', '%' . $request->position . '%');
        }

        if ($request->has('group')) {
            $query->whereRelation('taxonomies', 'id', $request->group);
        }

        if ($request->has('rank')) {
            $query->where('rank', 'LIKE', '%' . $request->rank . '%');
        }
    }

    public function scopeOfGroup($query, $group): void
    {
        $query->whereHas('taxonomies', function(Builder $q) use ($group) {
                $q->where('type', 'employee')
                ->where('slug', $group);
        });
    }

    public function scopeSorted($query, $request = []): void
    {
        isset($request['order']) ? $query->orderBy($request['order'], $request['sort']) : $query->orderBy('name', 'asc');
    }
}
