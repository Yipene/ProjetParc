<?php

namespace App\Models\Atelier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Equipement\Equipement;
use App\Models\Equipement\TypeEquipement;
use App\Models\User;
use App\Models\Technicien;
use App\Models\Client;
use App\Models\Service\Service;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'user_id',
        'equipement_id',
        'technicien_id',
        'date_reparation',
        'panne',
        'action_reparation',
        'date_fin_reparation',
        'observations',
        'statut'
    ];

    protected $casts = [
        'date_reparation' => 'datetime',
        'date_fin_reparation' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function technicien()
    {
        return $this->belongsTo(Technicien::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function equipement()
    {
        return $this->belongsTo(Equipement::class, 'equipement_id');
    }

    public function typeEquipement()
    {
        return $this->hasOneThrough(TypeEquipement::class, Equipement::class, 'id', 'id', 'equipement_id', 'type_equipement_id');
    }
}
