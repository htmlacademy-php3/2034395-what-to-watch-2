<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Film extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'poster_image',
        'preview_image',
        'background_image',
        'background_color',
        'video_link',
        'preview_video_link',
        'description',
        'director',
        'run_time',
        'released',
        'imdb_id',
        'status',
        'is_promo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get film genres
     *
     * @return HasMany
     */
    public function genres(): HasMany
    {
        return $this->hasMany('Genre');
    }

    /**
     * Get film actors
     *
     * @return HasMany
     */
    public function actors(): HasMany
    {
        return $this->hasMany('Actor');
    }

    /**
     * Get film comments
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany('Comment', 'comment_type');
    }
}
