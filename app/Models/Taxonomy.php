<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;

    /**
     * Get the parent taxonomyable model.
     */
    public function taxonomyable()
    {
        return $this->morphTo();
    }
}
