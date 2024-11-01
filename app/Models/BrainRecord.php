<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrainRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brain_id',
        'opponent_id',
        'brain_discs',
        'opponent_discs',
        'is_first',
    ];
}
