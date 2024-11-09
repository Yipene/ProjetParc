<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restitution_equipements extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'restitution_equipement');
    }
}
