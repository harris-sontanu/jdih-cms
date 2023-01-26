<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function logoUrl($image)
    {
        return Storage::disk('public')->exists($image) 
            ? Storage::url($image) 
            : '/assets/admin/images/logo_icon.svg';
    }
}
