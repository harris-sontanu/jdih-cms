<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HelperTrait;

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

    public function legislations()
    {
        return $this->hasMany(Legislation::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value),
        );
    }

    public function scopeLaws($query)
    {
        return $query->where('type_id', 1);
    }

    public function scopeMonographs($query)
    {
        return $query->where('type_id', 2);
    }

    public function scopeArticles($query)
    {
        return $query->where('type_id', 3);
    }

    public function scopeJudgments($query)
    {
        return $query->where('type_id', 4);
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            return $query->orderBy($request['order'], $request['sort']);
        } else {
            return $query->orderBy('sort', 'asc');
        }
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('abbrev', 'LIKE', '%' . $search . '%')
                ->orWhere('desc', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeOrder($query, $request)
    {
        if (!empty($request['order']) AND $order = $request['order']) {
            $query->orderBy($order, $request['sort']);
        }
    }

}
