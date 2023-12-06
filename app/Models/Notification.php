<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Notification extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
