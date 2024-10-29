<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'description_en',
    ];
}
