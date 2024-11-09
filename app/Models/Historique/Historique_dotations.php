<?php

namespace App\Models\Historique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Equipement\Dotation;

class Historique_dotations extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dotation()
    {
        return $this->belongsTo(Dotation::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }
}
