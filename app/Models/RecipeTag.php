<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'tag_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
