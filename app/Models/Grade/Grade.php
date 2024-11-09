<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Grade extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->hasMany(User::class);
    }
}
