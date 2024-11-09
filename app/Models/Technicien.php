<?php

namespace App\Models;

use App\Models\Atelier\Maintenance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grade\Grade;

class Technicien extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function maintenance() {
        return $this->belongsToMany(Maintenance::class);
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
