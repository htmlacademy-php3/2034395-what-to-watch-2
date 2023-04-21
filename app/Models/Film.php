<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Film Eloquent Model
 *
 * @property integer $id
 * @property string $name
 * @property string $poster_image
 * @property string $preview_image
 * @property string $background_image
 * @property string $background_color
 * @property string $video_link
 * @property string $preview_video_link
 * @property string $description
 * @property string $director
 * @property integer $run_time
 * @property integer $released
 * @property string $imdb_id
 * @property string $status
 * @property boolean $is_promo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Film extends Model
{
    use SoftDeletes, HasFactory;

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
        return $this->hasMany('FilmGenre');
    }

    /**
     * Get film actors
     *
     * @return HasMany
     */
    public function actors(): HasMany
    {
        return $this->hasMany('FilmActor');
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
