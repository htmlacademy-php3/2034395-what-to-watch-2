<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comment Eloquent Model
 *
 * @property integer $id
 * @property string $comment_type
 * @property integer $comment_id
 * @property string $text
 * @property integer $rating
 * @property integer $user_id
 * @property integer $reply_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Comment extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment_type',
        'comment_id',
        'text',
        'rating',
        'user_id',
        'reply_id',
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
     * Get reply
     *
     * @return HasOne
     */
    public function reply(): hasOne
    {
        return $this->hasOne('Comment', 'reply_id');
    }

    /**
     * Get user
     *
     * @returns HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne('User');
    }
}
