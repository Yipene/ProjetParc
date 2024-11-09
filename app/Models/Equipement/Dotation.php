<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Service\Service;
use App\Models\User;

class Dotation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function equipement()
    {
        return $this->belongsTo(Equipement::class, 'equipement_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restitutions()
    {
        return $this->hasMany(Restitution::class);
    }
}
