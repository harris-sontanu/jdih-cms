<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

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
    ];

    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class);
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

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('position', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request)
    {
        if (!empty($request['name']) AND $name = $request['name']) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($request['position']) AND $position = $request['position']) {
            $query->where('position', 'LIKE', '%' . $position . '%');
        }

        if (!empty($request['group']) AND $group = $request['group']) {
            $query->join('employee_group', 'employees.id', '=', 'employee_group.employee_id')
                ->where('employee_group.group_id', $group);
        }

        if (!empty($request['rank']) AND $rank = $request['rank']) {
            $query->where('rank', 'LIKE', '%' . $rank . '%');
        }
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            return $query->orderBy($request['order'], $request['sort']);
        } else {
            return $query->orderBy('sort', 'asc');
        }
    }
}
