<?php

namespace App\Models;

use App\Enums\LegislationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Traits\HasLegislationDocument;
use App\Models\Traits\HasUser;
use App\Models\Traits\Publication;
use App\Models\Traits\TimeFormatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cookie;

class Legislation extends Model
{
    use HasFactory, SoftDeletes, TimeFormatter, Publication, HasLegislationDocument, HasUser;

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
        'status'       => LegislationStatus::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function relations(): HasMany
    {
        return $this->hasMany(LegislationRelationship::class);
    }

    public function scopeOfRelation($query, $type): void
    {
        $query->whereRelation('relations', 'type', $type);
    }

    public function matters(): BelongsToMany
    {
        return $this->belongsToMany(Matter::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LegislationLog::class)->latest();
    }

    public function typeFlatButton(): Attribute
    {
        $button = match ($this->category->type_id) {
            1   => '<button type="button" class="btn btn-flat-success rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-scales m-1"></i></button>',
            2   => '<button type="button" class="btn btn-flat-indigo rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-books m-1"></i></button>',
            3   => '<button type="button" class="btn btn-flat-primary rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-newspaper m-1"></i></button>',
            4   => '<button type="button" class="btn btn-flat-danger rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-stamp m-1"></i></button>',
        };

        return Attribute::make(
            get: fn ($value) => $button
        );
    }

    public function shortTitle(): Attribute
    {
        $shortTitle = match ($this->category->type_id) {
            1   => $this->category->name . ' Nomor ' . $this->code_number . ' Tahun ' . $this->year,
            4   => 'Putusan ' . Str::title($this->justice) . ' Nomor ' . $this->code_number,
            default => $this->title,
        };

        return Attribute::make(
            get: fn ($value) => $shortTitle
        );
    }

    public function excerpt(): Attribute
    {
        $excerpt = match ($this->category->type_id) {
            2 => '<span class="fw-semibold">T.E.U. Orang/Badan:</span> ' . $this->author . '<br /><span class="fw-semibold">Penerbit:</span> ' . $this->publisher,
            3 => '<span class="fw-semibold">T.E.U. Orang/Badan:</span> ' . $this->author . '<br /><span class="fw-semibold">Sumber:</span> ' . $this->source,
            default => strip_tags($this->title),
        };

        return Attribute::make(
            get: fn ($value) => $excerpt
        );
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

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('category', 'name', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('category', 'abbrev', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request): void
    {
        if ($request->has('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->has('type')) {
            $query->whereRelation('category', 'type_id', $request->type);
        }

        if ($request->has('types')) {
            $types = $request->types;
            $query->whereHas('category.type', function (Builder $q) use ($types) {
                $q->whereIn('slug', $types);
            });
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('categories')) {
            $categories = $request->categories;
            $query->whereHas('category', function (Builder $q) use ($categories) {
                $q->whereIn('slug', $categories);
            });
        }

        if ($request->has('code_number')) {
            $query->where('code_number', 'LIKE', '%' . $request->code_number . '%');
        }

        if ($request->has('number')) {
            $query->where('number', $request->number);
        }

        if ($request->has('month')) {
            $query->whereMonth('published', $request->month);
        }

        if ($request->has('year')) {
            $query->where('year', $request->year);
        }

        if ($request->has('approved')) {
            $query->whereDate('approved', Carbon::parse($request->approved)->format('Y-m-d'));
        }

        if ($request->has('rgapproved')) {
            $dates = explode(' - ', $request->rgapproved);
            $fromDate = Carbon::createFromFormat('d/m/Y', $dates[0]);
            $toDate = Carbon::createFromFormat('d/m/Y', $dates[1]);
            $query->whereBetween('approved', [Carbon::parse($fromDate)->format('Y-m-d'), Carbon::parse($toDate)->format('Y-m-d')]);
        }

        if ($request->has('published')) {
            $query->whereDate('published', Carbon::parse($request->published)->format('Y-m-d'));
        }

        if ($request->has('rgpublished')) {
            $dates = explode(' - ', $request->rgpublished);
            $fromDate = Carbon::createFromFormat('d/m/Y', $dates[0]);
            $toDate = Carbon::createFromFormat('d/m/Y', $dates[1]);
            $query->whereBetween('published', [Carbon::parse($fromDate)->format('Y-m-d'), Carbon::parse($toDate)->format('Y-m-d')]);
        }

        if ($request->has('place')) {
            $query->where('place', 'LIKE', '%' . $request->place . '%');
        }

        if ($request->has('source')) {
            $query->where('source', 'LIKE', '%' . $request->source . '%');
        }

        if ($request->has('subject')) {
            $query->where('subject', 'LIKE', '%' . $request->subject . '%');
        }

        if ($request->has('language')) {
            $query->where('language', 'LIKE', '%' . $request->language . '%');
        }

        if ($request->has('author')) {
            $query->where('author', 'LIKE', '%' . $request->author . '%');
        }

        if ($request->has('institute')) {
            $query->where('institute_id', $request->institute);
        }

        if ($request->has('institutes')) {
            $institutes = $request->institutes;
            $query->whereHas('institute', function (Builder $q) use ($institutes) {
                $q->whereIn('slug', $institutes);
            });
        }

        if ($request->has('field')) {
            $query->where('field_id', $request->field);
        }

        if ($request->has('fields')) {
            $fields = $request->fields;
            $query->whereHas('field', function (Builder $q) use ($fields) {
                $q->whereIn('slug', $fields);
            });
        }

        if ($request->has('signer')) {
            $query->where('signer', 'LIKE', '%' . $request->signer . '%');
        }

        if ($request->has('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->enum('status', LegislationStatus::class));
        }

        if ($request->has('statuses')) {
            $query->whereIn('status', $request->statuses);
        }

        if ($request->has('matter')) {
            $query->whereRelation('matters', 'id', $request->matter);
        }

        if ($request->has('matters')) {
            $matters = $request->matters;
            $query->whereHas('matters', function (Builder $q) use ($matters) {
                $q->whereIn('slug', $matters);
            });
        }

        if ($request->has('created_at')) {
            $query->whereDate('created_at', Carbon::parse($request->created_at)->format('Y-m-d'));
        }

        if ($request->has('user')) {
            $query->whereRelation('user', 'id', $request->user);
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

        if ($request->has('isbn')) {
            $query->where('isbn', 'LIKE', '%' . $request->isbn . '%');
        }

        if ($request->has('desc')) {
            $query->where('desc', 'LIKE', '%' . $request->desc . '%');
        }

        if ($request->has('index_number')) {
            $query->where('index_number', 'LIKE', '%' . $request->index_number . '%');
        }

        if ($request->has('publisher')) {
            $query->where('publisher', 'LIKE', '%' . $request->publisher . '%');
        }

        if ($request->has('edition')) {
            $query->where('edition', 'LIKE', '%' . $request->edition . '%');
        }

        if ($request->has('call_number')) {
            $query->where('call_number', 'LIKE', '%' . $request->call_number . '%');
        }
    }

    public function scopeSorted($query, $request = []): void
    {
        if (isset($request['order'])) {
            match ($request['order']) {
                'category'  => $query->orderBy('category_name', $request['sort']),
                'user'      => $query->orderBy('user_name', $request['sort']),
                'latest'    => $query->latest(),
                'latest-approved'   => $query->latest('published'),
                'popular'   => $query->orderBy('view', 'desc'),
                'number-asc'=> $query->orderBy('number', 'asc'),
                'most-viewed'   => $query->orderBy('view', 'desc'),
                'rare-viewed'   => $query->orderBy('view', 'asc'),
                default     => $query->orderBy($request['order'], $request['sort']),
            };
        } else {
            $query->latest();
        }
    }

    public function scopeLatestApproved($query): void
    {
        $query->orderBy('published', 'desc');
    }

    public function scopeOfType($query, $typeId): void
    {
        $query->whereRelation('category', 'type_id', $typeId);
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
