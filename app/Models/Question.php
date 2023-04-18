<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type'  => QuestionType::class,
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeIdentities($query): void
    {
        $query->where('type', QuestionType::IDENTITY);
    }

    public function scopeQuestions($query): void
    {
        $query->where('type', QuestionType::QUESTION);
    }
}
