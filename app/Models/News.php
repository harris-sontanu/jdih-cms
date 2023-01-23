<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * Get the news's taxonomy.
     */
    public function taxonomy()
    {
        return $this->morphOne(Taxonomy::class, 'taxonomyable');
    }
}
