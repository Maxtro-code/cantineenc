<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Appliquer le middleware auth à toutes les méthodes
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Affiche les réservations de l'utilisateur connecté
    public function index()
    {
        try {
            $userId = Auth::id();

            // Vérification de sécurité
            if (!$userId) {
                return redirect()->route('login')->with('error', 'Vous devez être connecté.');
            }

            // Récupération des réservations
            $reservations = Reservation::where('user_id', $userId)
                ->orderBy('date')
                ->get();

            // Transmettre la variable à la vue
            //dd($reservations);
            //return view('reservations.index', compact('reservations'));
            return view('welcome', compact('reservations'));


        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des réservations : ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    // Ajouter une réservation
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        try {
            $reservation = new Reservation();
            $reservation->user_id = Auth::id();
            $reservation->date = $request->date;
            $reservation->save();

            return redirect()->route('reservations.index')
                ->with('success', 'Réservation ajoutée avec succès !');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'ajout de la réservation : ' . $e->getMessage());
            return back()->with('error', 'Impossible d\'ajouter la réservation.');
        }
    }
}
