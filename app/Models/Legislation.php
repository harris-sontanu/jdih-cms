<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Traits\HelperTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;

class Legislation extends Model
{
    use HasFactory, SoftDeletes, HelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'code_number',
        'number',
        'year',
        'call_number',
        'edition',
        'place',
        'location',
        'approved',
        'published',
        'publisher',
        'source',
        'subject',
        'status',
        'language',
        'author',
        'institute_id',
        'field_id',
        'signer',
        'desc',
        'isbn',
        'index_number',
        'justice',
        'user_id',
        'published_at',
        'note',
    ];

    protected $casts  = [
        'approved'     => 'date',
        'published'    => 'date',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relations()
    {
        return $this->hasMany(LegislationRelationship::class);
    }

    public function scopeOfRelation($query, $type)
    {
        return $query->whereRelation('relations', 'type', $type);
    }

    public function documents()
    {
        return $this->hasMany(LegislationDocument::class);
    }

    public function matters()
    {
        return $this->belongsToMany(Matter::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function logs()
    {
        return $this->hasMany(LegislationLog::class)->latest();
    }

    public function typeFlatButton(): Attribute
    {
        if ($this->category->type_id === 1) {
            $button = '<button type="button" class="btn btn-flat-success rounded-pill p-1" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-scales m-1"></i></button>';
        } else if ($this->category->type_id === 2) {
            $button = '<button type="button" class="btn btn-flat-indigo rounded-pill p-1" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-books m-1"></i></button>';
        } else if ($this->category->type_id === 3) {
            $button = '<button type="button" class="btn btn-flat-primary rounded-pill p-1" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-newspaper m-1"></i></button>';
        } else if ($this->category->type_id === 4) {
            $button = '<button type="button" class="btn btn-flat-danger rounded-pill p-1" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-stamp m-1"></i></button>';
        }

        return Attribute::make(
            get: fn ($value) => $button
        );
    }

    public function shortTitle(): Attribute
    {
        $shortTitle = $this->category->type_id === 1
            ? $this->category->name . ' Nomor ' . $this->code_number . ' Tahun ' . $this->year
            : $this->title;

        return Attribute::make(
            get: fn ($value) => $shortTitle
        );
    }

    public function excerpt(): Attribute
    {
        $excerpt = match ($this->category->type_id) {
            2 => '<span class="text-muted">T.E.U. Orang/Badan:</span> ' . $this->author . '<br /><span class="text-muted">Penerbit:</span> ' . $this->publisher,
            3 => '<span class="text-muted">T.E.U. Orang/Badan:</span> ' . $this->author . '<br /><span class="text-muted">Sumber:</span> ' . $this->source,
            default => $this->title,
        };

        return Attribute::make(
            get: fn ($value) => $excerpt
        );
    }

    public function statusBadge(): Attribute
    {
        if ($this->status == 'berlaku') {
            $statusBadge = '<span class="badge bg-success bg-opacity-20 text-success">'.Str::title($this->status).'</span>';
        } else if ($this->status == 'tidak berlaku') {
            $statusBadge = '<span class="badge bg-danger bg-opacity-20 text-danger">'.Str::title($this->status).'</span>';
        } else {
            $statusBadge = '<span class="badge bg-info bg-opacity-20 text-info">'.Str::title($this->status).'</span>';
        }

        return Attribute::make(
            get: fn ($value) => $statusBadge
        );
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

    public function approved(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d-m-Y'),
            set: fn ($value) => Carbon::parse($value)->translatedFormat('Y-m-d'),
        );
    }

    public function published(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d-m-Y'),
            set: fn ($value) => Carbon::parse($value)->translatedFormat('Y-m-d'),
        );
    }

    public function published_at(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d-m-Y H:i:s'),
            set: fn ($value) => Carbon::parse($value)->translatedFormat('Y-m-d H:i:s'),
        );
    }

    public function matterString(): Attribute
    {
        $matters = $this->matters()->where('matter_id', '=', $this->id)->pluck('name');

        return Attribute::make(
            get: fn ($value) => implode(",", $matters->all())
        );
    }

    public function mattersList(): Attribute
    {
        $matters = $this->matters()->pluck('name');
        $mattersList = $matters->count() > 0 ? implode(", ", $matters->all()) : null;

        return Attribute::make(
            get: fn ($value) => $mattersList
        );
    }

    public function downloadCount(): Attribute
    {
        $count = $this->documents()->sum('download');

        return Attribute::make(
            get: fn ($value) => $count
        );
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

    public function scopePopular($query, $days = 7)
    {
        return $query->where('published_at', '>', Carbon::now()->subDays($days))
            ->orderBy('view', 'desc');
    }

    public function masterDocumentSource(): Attribute
    {
        $master = $this->documents()
            ->ofType('master')
            ->first();

        return Attribute::make(
            get: fn ($value) => empty($master) ? null : Storage::url($master->media->path)
        );
    }

    public function coverThumbSource(): Attribute
    {
        $cover = $this->documents()
            ->ofType('cover')
            ->first();

        $coverThumbUrl = asset('assets/jdih/images/placeholders/placeholder.jpg');
        if (!empty($cover)) {
            $ext = substr(strchr($cover->media->path, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_md.{$ext}", $cover->media->path);
            if (Storage::disk('public')->exists($thumbnail)) $coverThumbUrl = Storage::url($thumbnail);
        }

        return Attribute::make(
            get: fn ($value) => $coverThumbUrl
        );
    }

    public function scopeSearch($query, $request)
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('category', 'name', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('category', 'abbrev', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request)
    {
        if ($title = $request->title AND $title = $request->title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        if ($type = $request->type AND $type = $request->type) {
            $query->whereRelation('category', 'type_id', $type);
        }

        if ($category = $request->category AND $category = $request->category) {
            $query->where('category_id', $category);
        }

        if ($code_number = $request->code_number AND $code_number = $request->code_number) {
            $query->where('code_number', 'LIKE', '%' . $code_number . '%');
        }

        if ($number = $request->number AND $number = $request->number) {
            $query->where('number', $number);
        }

        if ($month = $request->month AND $month = $request->month) {
            $query->whereMonth('published', $month);
        }

        if ($year = $request->year AND $year = $request->year) {
            $query->where('year', $year);
        }

        if ($approved = $request->approved AND $approved = $request->approved) {
            $query->whereDate('approved', Carbon::parse($approved)->format('Y-m-d'));
        }

        if ($published = $request->published AND $published = $request->published) {
            $query->whereDate('published', Carbon::parse($published)->format('Y-m-d'));
        }

        if ($place = $request->place AND $place = $request->place) {
            $query->where('place', 'LIKE', '%' . $place . '%');
        }

        if ($source = $request->source AND $source = $request->source) {
            $query->where('source', 'LIKE', '%' . $source . '%');
        }

        if ($subject = $request->subject AND $subject = $request->subject) {
            $query->where('subject', 'LIKE', '%' . $subject . '%');
        }

        if ($language = $request->language AND $language = $request->language) {
            $query->where('language', 'LIKE', '%' . $language . '%');
        }

        if ($author = $request->author AND $author = $request->author) {
            $query->where('author', 'LIKE', '%' . $author . '%');
        }

        if ($institute = $request->institute AND $institute = $request->institute) {
            $query->where('institute_id', $institute);
        }

        if ($field = $request->field AND $field = $request->field) {
            $query->where('field_id', $field);
        }

        if ($signer = $request->signer AND $signer = $request->signer) {
            $query->where('signer', 'LIKE', '%' . $signer . '%');
        }

        if ($location = $request->location AND $location = $request->location) {
            $query->where('location', 'LIKE', '%' . $location . '%');
        }

        if ($status = $request->status AND $status = $request->status) {
            $query->where('status', $status);
        }

        if ($matter = $request->matter AND $matter = $request->matter) {
            $query->whereRelation('matters', 'id', $matter);
        }

        if ($created_at = $request->created_at AND $created_at = $request->created_at) {
            $query->whereDate('created_at', Carbon::parse($created_at)->format('Y-m-d'));
        }

        if ($user = $request->user AND $user = $request->user) {
            $query->whereRelation('user', 'id', $user);
        }

        if ($request->no_master) {
            $query->whereDoesntHave('documents', function (Builder $q) {
                $q->where('type', 'master');
            });
        }

        if ($request->no_abstract) {
            $query->whereDoesntHave('documents', function (Builder $q) {
                $q->where('type', 'abstract');
            });
        }

        if ($isbn = $request->isbn AND $isbn = $request->isbn) {
            $query->where('isbn', 'LIKE', '%' . $isbn . '%');
        }

        if ($desc = $request->desc AND $desc = $request->desc) {
            $query->where('desc', 'LIKE', '%' . $desc . '%');
        }

        if ($index_number = $request->index_number AND $index_number = $request->index_number) {
            $query->where('index_number', 'LIKE', '%' . $index_number . '%');
        }

        if ($publisher = $request->publisher AND $publisher = $request->publisher) {
            $query->where('publisher', 'LIKE', '%' . $publisher . '%');
        }

        if ($edition = $request->edition AND $edition = $request->edition) {
            $query->where('edition', 'LIKE', '%' . $edition . '%');
        }

        if ($call_number = $request->call_number AND $call_number = $request->call_number) {
            $query->where('call_number', 'LIKE', '%' . $call_number . '%');
        }
    }

    public function scopeSorted($query, $request = [])
    {
        if (isset($request['order'])) {
            if ($request['order'] === 'category') {
                $query->orderBy('category_name', $request['sort']);
            } else if ($request['order'] === 'user') {
                $query->orderBy('user_name', $request['sort']);
            } else if ($request['order'] === 'latest') {
                $query->latest();
            } else if ($request['order'] === 'latest-approved') {
                $query->orderBy('published', 'desc');
            } else if ($request['order'] === 'popular') {
                $query->orderBy('view', 'desc');
            } else if ($request['order'] === 'number-asc') {
                $query->orderBy('number', 'asc');
            } else if ($request['order'] === 'most-viewed') {
                $query->orderBy('view', 'desc');
            } else if ($request['order'] === 'rare-viewed') {
                $query->orderBy('view', 'asc');
            } else {
                $query->orderBy($request['order'], $request['sort']);
            }
        } else {
            $query->latest();
        }

        return $query;
    }

    public function scopeLatestApproved($query)
    {
        return $query->orderBy('published', 'desc');
    }

    public function scopeLatestPublished($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeOfType($query, $typeId)
    {
        return $query->whereRelation('category', 'type_id', $typeId);
    }

    public function scopeMonographs($query)
    {
        return $query->select(['legislations.*', 'categories.slug AS category_slug', 'categories.abbrev AS category_abbrev', 'categories.name AS category_name', 'users.name AS user_name', 'users.picture AS user_picture'])
            ->join('categories', 'legislations.category_id', '=', 'categories.id')
            ->join('users', 'legislations.user_id', '=', 'users.id')
            ->where('type_id', '=', 2);
    }

    public function scopeArticles($query)
    {
        return $query->select(['legislations.*', 'categories.slug AS category_slug', 'categories.abbrev AS category_abbrev', 'categories.name AS category_name', 'users.name AS user_name', 'users.picture AS user_picture'])
            ->join('categories', 'legislations.category_id', '=', 'categories.id')
            ->join('users', 'legislations.user_id', '=', 'users.id')
            ->where('type_id', '=', 3);
    }

    public function scopeJudgments($query)
    {
        return $query->select(['legislations.*', 'categories.slug AS category_slug', 'categories.abbrev AS category_abbrev', 'categories.name AS category_name', 'users.name AS user_name', 'users.picture AS user_picture'])
            ->join('categories', 'legislations.category_id', '=', 'categories.id')
            ->join('users', 'legislations.user_id', '=', 'users.id')
            ->where('type_id', '=', 4);
    }

    public function publisher(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value)
        );
    }

    public function place(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value)
        );
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
