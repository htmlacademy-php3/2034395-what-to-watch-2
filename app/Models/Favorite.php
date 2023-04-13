<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Favorite Eloquent Model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $film_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Favorite extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'film_id',
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
     * Get user
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne('User');
    }

    /**
     * Get film
     *
     * @return HasOne
     */
    public function film(): HasOne
    {
        return $this->hasOne('Film');
    }
}
