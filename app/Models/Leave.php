<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Leave extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'startdatetime',
        'enddatetime',
        'leave_reason',
        'leave_status',
        'reject_reason',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
