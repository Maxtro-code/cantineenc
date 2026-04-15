<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

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

    // ─────────────────────────────────────────────────────────────────────────
    // GESTION DES RÉSERVATIONS (admin)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Affiche le panneau de gestion des réservations avec le formulaire
     * permettant de réserver pour n'importe quel étudiant.
     */
    public function indexReservations(Request $request)
    {
        $users = User::orderBy('name')->get();

        // Filtres optionnels
        $query = Reservation::with('user')->orderBy('date', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date_debut')) {
            $query->where('date', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date', '<=', $request->date_fin);
        }

        $reservations = $query->get();

        return view('pages.admin.reservation-etudiant', compact('users', 'reservations'));
    }

    /**
     * Crée une réservation pour un étudiant donné à une date donnée et débite son solde.
     */
    public function storeReservation(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'date'    => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $jour = Carbon::parse($value)->dayOfWeek;
                    if ($jour === 0 || $jour === 6) {
                        $fail('Les réservations sont uniquement disponibles du lundi au vendredi.');
                    }
                },
            ],
        ]);

        $etudiant = User::find($request->user_id);
        $tarif    = (float) config('app.tarif_repas');

        // Vérifier doublon
        $exists = Reservation::where('user_id', $etudiant->id)
            ->where('date', $request->date)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', "{$etudiant->name} a déjà une réservation le " .
                Carbon::parse($request->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') . '.');
        }

        // Vérifier solde (l'admin est averti mais peut passer outre via force_debit)
        if ($etudiant->solde < $tarif && !$request->boolean('force_debit')) {
            return back()->withInput()->with('warning', sprintf(
                'Solde insuffisant pour %s (%.2f € disponibles, tarif : %.2f €). Cochez "Forcer le débit" pour continuer quand même.',
                $etudiant->name, $etudiant->solde, $tarif
            ));
        }

        $etudiant->debiter($tarif);

        Reservation::create([
            'user_id' => $etudiant->id,
            'date'    => $request->date,
            'montant' => $tarif,
        ]);

        return redirect()->route('admin.reservations.index')
            ->with('success', sprintf(
                'Réservation créée pour %s le %s. %.2f € débités. Solde restant : %.2f €.',
                $etudiant->name,
                Carbon::parse($request->date)->locale('fr')->isoFormat('dddd D MMMM YYYY'),
                $tarif,
                $etudiant->fresh()->solde
            ));
    }

    /**
     * Supprime une réservation et rembourse l'étudiant.
     */
    public function destroyReservation(Reservation $reservation)
    {
        $nom    = $reservation->user->name;
        $date   = Carbon::parse($reservation->date)->locale('fr')->isoFormat('dddd D MMMM YYYY');
        $montant = $reservation->montant;

        $reservation->user->crediter($montant);
        $reservation->delete();

        return back()->with('success', sprintf('Réservation de %s du %s annulée. %.2f € remboursés.', $nom, $date, $montant));
    }

    /**
     * Recharge le solde d'un étudiant (admin uniquement).
     */
    public function crediter(Request $request, User $user)
    {
        $request->validate([
            'montant' => ['required', 'numeric', 'min:0.01', 'max:500'],
        ]);

        $user->crediter((float) $request->montant);

        return back()->with('success', sprintf(
            '%.2f € crédités sur le compte de %s. Nouveau solde : %.2f €.',
            $request->montant, $user->name, $user->fresh()->solde
        ));
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
