<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillables = [
        'name',
        'description',
        'is_exam',
        'path',
        'order',
        'color'
    ];
}
