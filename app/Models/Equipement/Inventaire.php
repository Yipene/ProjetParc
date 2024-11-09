<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service\Service;

class Inventaire extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
