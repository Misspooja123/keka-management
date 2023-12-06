<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Marksheet extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'mathematics',
        'science',
        'socialscience',
        'english',
        'gujarati',
        'hindi',
        'total',
        'percentage',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

