<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'recipe_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function recipe()
    {
        $this->belongsTo(Recipe::class);
    }
}
