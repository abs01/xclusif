<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Earning extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'post_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user that earned this amount.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post associated with this earning.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
