<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Equipement\Dotation;

class Service extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->hasMany(User::class);
    }

    public function dotations()
    {
        return $this->hasMany(Dotation::class);
    }
}
