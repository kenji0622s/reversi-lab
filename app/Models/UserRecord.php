<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brain_id',
        'user_discs',
        'brain_discs',
        'is_first',
    ];

    public function brain()
    {
        return $this->belongsTo(Brain::class);
    }
}
