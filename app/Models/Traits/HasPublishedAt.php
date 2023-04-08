<?php
namespace App\Models\Traits;

use Illuminate\Support\Carbon;

trait HasPublishedAt
{
    public function publicationStatus()
    {
        if (is_null($this->published_at)) {
            $status = 'draft';
        } else if (isset($this->published_at) AND $this->published_at->isFuture()) {
            $status = 'schedule';
        } else if (isset($this->deleted_at)) {
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

    public function scopePopular($query, $days = 365)
    {
        return $query->where('published_at', '>', Carbon::now()->subDays($days))
            ->orderBy('view', 'desc');
    }

    public function scopeLatestPublished($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}
