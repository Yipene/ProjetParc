<?php

namespace App\Models\Historique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipement\Acquisition;
use App\Models\User;

class Historique_acquisitions extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function acquisition()
    {
        return $this->belongsTo(Acquisition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}
