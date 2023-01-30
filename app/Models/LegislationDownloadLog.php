<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegislationDownloadLog extends Model
{
    use HasFactory;

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;
}
