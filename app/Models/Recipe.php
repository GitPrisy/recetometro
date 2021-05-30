<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'mean_id',
        'ingredients',
        'preparation',
        'user_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mean()
    {
        return $this->belongsTo(Mean::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->hasMany(RecipeTag::class);
    }
}
