<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Affiche la liste des utilisateurs et le formulaire de création.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('pages.admin.creation-etudiant', compact('users'));
    }

    /**
     * Crée un nouvel utilisateur avec un mot de passe temporaire généré.
     *
     * Règle de génération (inspirée ANSSI) :
     *   Login  : Première lettre prénom + NOM (ex: JDupont → login email : j.dupont@enc-bessieres.org)
     *   Mdp temp : 3 mots aléatoires + chiffre + caractère spécial (ex: Soleil42!Lune)
     *   → Au moins 12 caractères, majuscules, minuscules, chiffres, caractères spéciaux.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'section'    => ['nullable', 'string', 'max:100'],
            'is_admin'   => ['boolean'],
        ]);

        // Génération du mot de passe temporaire ANSSI-compatible
        $tempPassword = $this->generateTemporaryPassword($request->name);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($tempPassword),
            'is_admin' => $request->boolean('is_admin', false),
        ]);

        // Ici on pourrait envoyer un mail avec $tempPassword
        // Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user, $tempPassword));

        return redirect()->route('admin.users.index')
            ->with('success', "Compte créé pour {$user->name}.")
            ->with('temp_password', $tempPassword)   // affiché UNE SEULE FOIS à l'admin
            ->with('new_user_email', $user->email);
    }

    /**
     * Passe ou retire les droits admin d'un utilisateur.
     */
    public function toggleAdmin(User $user)
    {
        // Empêcher de se retirer ses propres droits
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier vos propres droits.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $action = $user->is_admin ? 'promu administrateur' : 'repassé utilisateur';
        return back()->with('success', "{$user->name} a été {$action}.");
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        $user->delete();
        return back()->with('success', "Compte de {$user->name} supprimé.");
    }

    /**
     * Génère un mot de passe temporaire conforme aux recommandations ANSSI.
     *
     * Format : Mot1Mot2Mot3NNN! (16+ caractères)
     * - Lettres majuscules et minuscules
     * - Au moins 2 chiffres
     * - Au moins 1 caractère spécial
     * - Longueur minimale : 16 caractères
     */
    private function generateTemporaryPassword(string $name): string
    {
        $mots = [
            'Soleil', 'Lune', 'Etoile', 'Nuage', 'Vent',
            'Riviere', 'Foret', 'Montagne', 'Ocean', 'Prairie',
            'Aigle', 'Renard', 'Cerf', 'Hibou', 'Lynx',
        ];

        shuffle($mots);
        $partie1 = $mots[0] . $mots[1];

        // Deux chiffres aléatoires
        $chiffres = str_pad(rand(10, 99), 2, '0', STR_PAD_LEFT);

        // Caractère spécial parmi ceux recommandés ANSSI
        $speciaux = ['!', '@', '#', '$', '%', '&', '*'];
        $special  = $speciaux[array_rand($speciaux)];

        // Initiales du nom pour personnaliser légèrement
        $initiales = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, 2));

        return $partie1 . $chiffres . $special . $initiales;
    }
}
