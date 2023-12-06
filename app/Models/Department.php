<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Department extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'departments'; // Set the table name explicitly if it's different from the model name.

    protected $fillable = ['name', 'status']; // Define the fields to be mass assignable

    protected $dates = ['deleted_at'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'department_id', 'id');
    }
}
