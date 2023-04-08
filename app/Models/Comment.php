<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    use HasFactory;

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
