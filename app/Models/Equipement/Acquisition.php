<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Acquisition extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function equipement()
    {
        return $this->belongsTo(Equipement::class, 'equipement_id');
    }
}
