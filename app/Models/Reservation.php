<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
    'salle_id',
    'user_id',
    'direction_id',
    'start_time',
    'end_time',
    'nom_salle', // Ajouté
    'nom_utilisateur', // Ajouté
    'nom_direction', // Ajouté
    'motif', // Ajouté
    'status',
];

    public function salle()
{
    return $this->belongsTo(Salle::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function direction()
{
    return $this->belongsTo(Direction::class);
}
}
