<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mean extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
