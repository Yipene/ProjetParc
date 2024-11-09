<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restitution extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dotation()
    {
        return $this->belongsTo(Dotation::class);
    }
}
