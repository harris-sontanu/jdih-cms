<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeIdentities($query)
    {
        return $query->where('type', 'identity');
    }

    public function scopeQuestions($query)
    {
        return $query->where('type', 'question');
    }
}
