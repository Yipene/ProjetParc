<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Atelier\Maintenance;
use App\Models\Client;
use App\Models\User;

class Equipement extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function acquisition()
    {
        return $this->hasOne(Acquisition::class, 'equipement_id');
    }

    public function dotations()
    {
        return $this->hasMany(Dotation::class);
    }



    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }


    public function typeEquipement()
    {
        return $this->belongsTo(TypeEquipement::class, 'type_equipement_id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'equipement_id');
    }

    public function User()
    {
        return $this->hasMany(User::class);
    }
}
