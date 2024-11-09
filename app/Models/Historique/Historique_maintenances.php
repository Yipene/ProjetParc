<?php

namespace App\Models\Historique;

use App\Models\Atelier\Maintenance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Historique_maintenances extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
