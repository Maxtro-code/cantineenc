<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    // Middleware 'auth' géré dans routes/web.php

    /** Affiche les réservations de l'utilisateur connecté */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->orderBy('date')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    /** Enregistre une nouvelle réservation et débite le solde */
    public function store(Request $request)
    {
        $request->validate([
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $jour = Carbon::parse($value)->dayOfWeek;
                    if ($jour === 0 || $jour === 6) {
                        $fail('Les réservations sont uniquement disponibles du lundi au vendredi.');
                    }
                },
            ],
        ]);

        $user = Auth::user();

        // Vérifier doublon
        $exists = Reservation::where('user_id', $user->id)
            ->where('date', $request->date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà une réservation pour cette date.');
        }

        $tarif = (float) config('app.tarif_repas');

        // Débiter sans blocage — simple notification si solde bas
        $user->debiter($tarif);

        Reservation::create([
            'user_id' => $user->id,
            'date'    => $request->date,
            'montant' => $tarif,
        ]);

        $soldeRestant = $user->fresh()->solde;
        $message = sprintf('Réservation ajoutée. %.2f € débités.', $tarif);

        if ($soldeRestant < $tarif) {
            return redirect()->route('reservations.index')
                ->with('success', $message)
                ->with('warning', sprintf(
                    'Votre solde est bas (%.2f €). Pensez à recharger avant votre prochain repas.',
                    $soldeRestant
                ));
        }

        return redirect()->route('reservations.index')
            ->with('success', sprintf('%s Solde restant : %.2f €.', $message, $soldeRestant));
    }

    /** Supprime une réservation et rembourse le solde */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->date->isPast()) {
            return back()->with('error', 'Impossible d\'annuler une réservation passée.');
        }

        $montant = $reservation->montant;
        $reservation->delete();

        // Rembourser le montant débité
        Auth::user()->crediter($montant);

        return back()->with('success', sprintf('Réservation annulée. %.2f € remboursés sur votre solde.', $montant));
    }


    /** Recharge fictive du solde — tout utilisateur connecté peut créditer son compte */
    public function recharger(Request $request)
    {
        $request->validate([
            'montant' => ['required', 'numeric', 'min:0.01', 'max:500'],
        ]);

        Auth::user()->crediter((float) $request->montant);

        return back()->with('success', sprintf(
            '%.2f € ajoutés à votre solde. Nouveau solde : %.2f €.',
            $request->montant,
            Auth::user()->fresh()->solde
        ));
    }
}
