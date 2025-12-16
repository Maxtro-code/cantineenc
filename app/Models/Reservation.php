<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory; // Permet d'utiliser les factories pour les tests et seeders

    // Les colonnes qui peuvent être remplies via create() ou fill()
    protected $fillable = ['user_id', 'date'];

    // Si tu veux gérer la relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optionnel : si tu veux que la date soit automatiquement castée en instance Carbon
    protected $casts = [
        'date' => 'date',
    ];
}
