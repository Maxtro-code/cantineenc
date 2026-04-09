<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Peuple la base de données avec des données de démonstration.
     *
     * Comptes créés :
     *   admin@enc-bessieres.org  /  AdminENC2026!
     *   etudiant@enc-bessieres.org  /  Etudiant2026!
     */
    public function run(): void
    {
        // ── Compte administrateur ──────────────────────────────────────────
        $admin = User::updateOrCreate(
            ['email' => 'admin@enc-bessieres.org'],
            [
                'name'             => 'Administrateur ENC',
                'password'         => Hash::make('AdminENC2026!'),
                'is_admin'         => true,
                'email_verified_at'=> now(),
            ]
        );

        // ── Compte étudiant de démonstration ──────────────────────────────
        $etudiant = User::updateOrCreate(
            ['email' => 'marie.dupont@enc-bessieres.org'],
            [
                'name'             => 'Marie Dupont',
                'password'         => Hash::make('Soleil42!MD'),
                'is_admin'         => false,
                'email_verified_at'=> now(),
            ]
        );

        // ── Réservations de démonstration ─────────────────────────────────
        $dates = [
            now()->addDays(1)->format('Y-m-d'),
            now()->addDays(2)->format('Y-m-d'),
            now()->addDays(5)->format('Y-m-d'),
        ];

        foreach ($dates as $date) {
            Reservation::updateOrCreate(
                ['user_id' => $etudiant->id, 'date' => $date]
            );
        }

        $this->command->info('✅ Base de données peuplée avec succès.');
        $this->command->table(
            ['Rôle', 'Email', 'Mot de passe'],
            [
                ['Administrateur', 'admin@enc-bessieres.org', 'AdminENC2026!'],
                ['Étudiant',       'marie.dupont@enc-bessieres.org', 'Soleil42!MD'],
            ]
        );
    }
}
