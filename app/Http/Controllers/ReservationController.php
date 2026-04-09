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

    /** Enregistre une nouvelle réservation */
    public function store(Request $request)
    {
        $request->validate([
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $jour = Carbon::parse($value)->dayOfWeek;
                    // 0 = dimanche, 6 = samedi
                    if ($jour === 0 || $jour === 6) {
                        $fail('Les réservations sont uniquement disponibles du lundi au vendredi.');
                    }
                },
            ],
        ]);

        // Vérifier qu'il n'y a pas déjà une réservation pour cette date
        $exists = Reservation::where('user_id', Auth::id())
            ->where('date', $request->date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà une réservation pour cette date.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'date'    => $request->date,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation ajoutée avec succès !');
    }

    /** Supprime une réservation (uniquement la sienne) */
    public function destroy(Reservation $reservation)
    {
        // Sécurité : vérifier que la réservation appartient à l'utilisateur connecté
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // Empêcher la suppression d'une réservation passée
        if ($reservation->date->isPast()) {
            return back()->with('error', 'Impossible d\'annuler une réservation passée.');
        }

        $reservation->delete();

        return back()->with('success', 'Réservation annulée.');
    }
}
