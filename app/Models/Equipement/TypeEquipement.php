<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEquipement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function equipements()
    {
        return $this->hasMany(Equipement::class, 'type_equipement_id');
    }
}
