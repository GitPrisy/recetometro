<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        $this->hasMany(User::class);
    }
}
