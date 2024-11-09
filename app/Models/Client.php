<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipement\Equipement;
use App\Models\Service\Service;
use App\Models\Grade\Grade;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
