<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;
        protected $fillable = [
        'nom',
        'capacité',
        'description',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
