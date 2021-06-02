<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nickname',
        'email',
        'mailable',
        'password',
        'visible',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function recipes()
    {
        $this->hasMany(Recipe::class);
    }

    public function rol()
    {
        $this->belongsTo(Rol::class);
    }

    public function comments()
    {
        $this->hasMany(Comment::class);
    }

    public function votes()
    {
        $this->hasMany(Vote::class);
    }
}
