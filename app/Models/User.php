<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\HasUser;
use App\Enums\UserRole;
use App\Models\Traits\TimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, TimeFormatter, HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'www',
        'bio',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'youtube',
        'picture',
        'last_logged_in_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_logged_in_at' => 'datetime',
        'role'  => UserRole::class,
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function legislations(): HasMany
    {
        return $this->hasMany(Legislation::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function scopePending($query): void
    {
        $query->whereNull('deleted_at')
            ->whereNull('email_verified_at');
    }

    public function scopeActive($query): void
    {
        $query->whereNull('deleted_at')
            ->whereNotNull('email_verified_at');
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('role', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request): void
    {   
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->has('role')) {
            $query->where('role', $request->enum('role', UserRole::class));
        }

        if ($request->has('phone')) {
            $query->where('phone', 'LIKE', '%' . $request->phone . '%');
        }

        if ($request->has('www')) {
            $query->where('www', 'LIKE', '%' . $request->www . '%');
        }

        if ($request->has('bio')) {
            $query->where('bio', 'LIKE', '%' . $request->bio . '%');
        }

        if ($request->has('last_logged_in_at')) {
            $query->whereDate('last_logged_in_at', Carbon::parse($request->last_logged_in_at)->format('Y-m-d'));
        }

        if ($request->has('created_at')) {
            $query->whereDate('created_at', Carbon::parse($request->created_at)->format('Y-m-d'));
        }
    }

    public function scopeSorted($query, $request = []): void
    {   
        isset($request['order']) ? $query->orderBy($request['order'], $request['sort']) : $query->orderBy('name', 'asc');
    }

    public function status()
    {
        $status = 'aktif';
        if (is_null($this->email_verified_at)) $status = 'tinjau';
        if (isset($this->deleted_at)) $status = 'sampah';

        return $status;
    }

    public function statusBadge(): Attribute
    {
        $status = $this->status();

        $badge = match ($status) {
            'aktif' => '<span class="badge bg-success bg-opacity-20 text-success">'.Str::title($status).'</span>',
            'tinjau'=> '<span class="badge bg-warning bg-opacity-20 text-warning">'.Str::title($status).'</span>',
            'sampah'=> '<span class="badge bg-dark bg-opacity-20 text-dark">'.Str::title($status).'</span>',
            default => '<span class="badge bg-light bg-opacity-20 text-light">'.Str::title($status).'</span>',
        };

        return new Attribute(
            get: fn ($value) => $badge
        );
    }
}
