<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipe_id',
        'text',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function recipe()
    {
        $this->belongsTo(Recipe::class);
    }
}
