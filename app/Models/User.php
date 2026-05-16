<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Role;

use App\Models\Like;
use App\Models\Post;
use App\Models\Tier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
                                //Sanctum
    use HasFactory, Notifiable, HasApiTokens;


protected $fillable = [
    'name',
    'lastname',
    'dni',
    'email',
    'phone',
    'password',
    'tier_id',
    'role_id', 
];


    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }

        public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','following_id','follower_id')
            ->withPivot('is_vip')
            ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class,'followers','follower_id','following_id')
            ->withPivot('is_vip')
            ->withTimestamps();
    }

        public function isAdmin(): bool
    {
        return $this->role_id === Role::where('name', 'admin')->first()?->id;
    }

      public function isMod(): bool
    {
        return $this->role_id === Role::where('name', 'moderador')->first()?->id;
    }

}