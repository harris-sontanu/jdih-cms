<?php

namespace App\Models;

use App\Models\Traits\HelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class Media extends Model
{
    use HasFactory, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'path',
        'caption',
        'is_image',
        'size',
        'user_id',
        'published_at',
    ];

    protected $casts  = [
        'published_at' => 'datetime',
    ];

    public function mediaable()
    {
        return $this->morphTo();
    }

    public function news()
    {
        return $this->hasOne(News::class, 'cover_id');
    }

    public function page()
    {
        return $this->hasOne(Page::class, 'cover_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link()
    {
        return $this->hasOne(Link::class, 'image_id');
    }

    public function mediaUrl(): Attribute
    {
        $mediaUrl = asset('assets/admin/images/placeholders/placeholder.jpg');
        if (!empty($this->path)) {
            if (Storage::disk('public')->exists($this->path)) $mediaUrl = Storage::url($this->path);
        }

        return Attribute::make(
            get: fn ($value) => $mediaUrl
        );
    }

    public function mediaThumbUrl(): Attribute
    {
        $mediaThumbUrl = asset('assets/admin/images/placeholders/placeholder.jpg');
        if (!empty($this->path)) {
            $ext = substr(strchr($this->path, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_md.{$ext}", $this->path);
            if (Storage::disk('public')->exists($thumbnail)) $mediaThumbUrl = Storage::url($thumbnail);
        }

        return Attribute::make(
            get: fn ($value) => $mediaThumbUrl
        );
    }

    public function ext(): Attribute
    {
        $file = explode('.', $this->path);
        $ext = $file[1];

        return Attribute::make(
            get: fn ($value) => $ext
        );
    }

    public function extClass(): Attribute
    {
        $file = explode('.', $this->name);
        $ext = $file[1];

        if ($ext === 'pdf') {
            $class = 'ph-file-pdf text-danger';
        } else if ($ext === 'doc' OR $ext === 'docx') {
            $class = 'ph-file-doc text-primary';
        } else if ($ext === 'xls' OR $ext === 'xlsx') {
            $class = 'ph-file-xls text-success';
        } else if ($ext === 'ppt' OR $ext === 'pptx') {
            $class = 'ph-file-ppt text-warning';
        } else if ($ext === 'zip' OR $ext === 'rar') {
            $class = 'ph-file-zip text-teal';
        } else if ($ext === 'txt' OR $ext === 'rtf') {
            $class = 'ph-file-text text-pink';
        } else {
            $class = 'ph-file text-secondary';
        }

        return Attribute::make(
            get: fn ($value) => $class
        );
    }

    public function icon(): Attribute
    {
        $ext = substr(strchr($this->path, '.'), 1);
        if ($ext === 'pdf') {
            $icon = '<i class="ph-file-pdf ph-2x text-danger"></i>';
        } else if ($ext === 'doc' OR $ext === 'docx') {
            $icon = '<i class="ph-file-doc ph-2x text-primary"></i>';
        } else if ($ext === 'xls' OR $ext === 'xlsx') {
            $icon = '<i class="ph-file-xls ph-2x text-success"></i>';
        } else if ($ext === 'ppt' OR $ext === 'pptx') {
            $icon = '<i class="ph-file-ppt ph-2x text-warning"></i>';
        } else if ($ext === 'zip' OR $ext === 'rar') {
            $icon = '<i class="ph-file-zip ph-2x text-purple"></i>';
        } else if ($ext === 'png' OR $ext === 'jpg' OR $ext === 'jpeg') {
            $icon = '<i class="ph-file-image ph-2x text-yellow"></i>';
        } else if ($ext === 'mp4' OR $ext === 'avi' OR $ext === 'mkv') {
            $icon = '<i class="ph-file-video ph-2x text-indigo"></i>';
        } else {
            $icon = '<i class="ph-file-text ph-2x text-info"></i>';
        }

        return Attribute::make(
            get: fn ($value) => $icon
        );
    }

    public function size($precision = 2)
    {
        $bytes = 0;
        if (Storage::disk('public')->exists($this->path)) {
            $bytes = Storage::disk('public')->size($this->path);
        }

        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
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

    public function scopeImages($query)
    {
        return $query->where('is_image', 1);
    }

    public function scopeFiles($query)
    {
        return $query->where('is_image', 0)
            ->whereNull('mediaable_id');
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
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('caption', 'LIKE', '%' . $search . '%');
        }
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            if ($request['order'] === 'user') {
                $query->join('users', 'users.id', '=', 'media.user_id')
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
