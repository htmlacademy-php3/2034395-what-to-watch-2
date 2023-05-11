<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'films_genres');
    }

    /**
     * Get film actors
     *
     * @return BelongsToMany
     */
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'films_actors');
    }

    /**
     * Get film comments
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get favorites
     *
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get rating
     *
     * @return float
     */
    public function rating(): float
    {
        $comments = $this->comments()->where('rating', '>', 0)->get()->all();

        $gradesSum = array_reduce($comments, function ($carry, $item) {
            $carry += $item->rating;

            return $carry;
        }, 0);

        if ($gradesSum > 0) {
            return $gradesSum / count($comments);
        }

        return 0;
    }
}
