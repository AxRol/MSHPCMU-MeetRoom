<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Salle;
use App\Models\Direction;
use App\Models\User;
use App\Policies\ReservationPolicy;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $this->authorize('viewAny', Reservation::class); //autorisation via policies
        $userId = Auth::id();
        $reservationsUser = Reservation::where('user_id', $userId)->get();

        If (Auth::check() && Auth::user()->hasRole('utilisateur')){
             return view('reservations.index', compact('reservationsUser'));
        }
         $reservations = Reservation::with(['salle', 'user', 'direction'])->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Reservation::class); //autorisation via policies
        $salle_id = $request->input('salle_id');
        $salles = Salle :: all();
        $directions = Direction:: all();
        return view('reservations.create', compact('salles', 'directions', 'salle_id'));
    }


    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Reservation::class); //autorisation via policies
        $this->validate($request, [
        //
        'salle_id' => 'required',
        'direction_id' => 'required',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'user_id' => 'required|exists:users,id',
        ]);

        $sallenom = 'Non spécifiée';

        $reservation = Reservation::create($request->all());
            //   $request->user()->notify(new ReservationCreated($reservation));

            if ($reservation->salle) {
                $sallenom = $reservation->salle->nom;
            }

            // Rediriger avec un message de succès
            return redirect()->route('reservations.index')->with('success', "Réservation pour la salle : $sallenom créée avec succès.");

    }

    /**
     * Display the specified reservation.
     */
    public function show(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('view', $reservation);  //autorisation via policies
        $salles = Salle::all();
        $directions = Direction::all();
        return view('reservations.show', compact('reservation', 'salles', 'directions'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('update', $reservation); //autorisation via policies
        $salles = Salle::all();
        $directions = Direction::all();
        return view('reservations.edit', compact('reservation', 'salles', 'directions'));
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('update', $reservation); //autorisation via plicies
        $reservation->update($request->all());
        $sallenom = 'Non spécifiée';
            if ($reservation->salle) {
                $sallenom = $reservation->salle->nom;
            }
    //    return redirect()->route('reservations.show', $reservation->id);
    return redirect()->route('reservations.index')->with('success', "Réservation pour la salle : $sallenom modifiée avec succès.");
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('delete', $reservation); //autorisation via policies
        $reservation->delete();
        return redirect()->route('reservations.index');
    }

/*     public function valider(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('validate', $reservation); //autorisation via plicies

        // Vérifier si la réservation peut être validée (par exemple, si elle n'est pas déjà annulée)
        if ($reservation->status === 'annulé') {
            return redirect()->route('reservations.index')->with('error', 'La réservation est annulée et ne peut pas être validée.');
        }

        // Mettre à jour le statut de la réservation
        $reservation->update(['status' => 'validé']);

        return redirect()->route('reservations.index')->with('success', 'Réservation validée avec succès.');
    } */

    public function valider(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('validate', $reservation);

        // Vérifier si la réservation peut être validée
        if ($reservation->status === 'annulé') {
            return redirect()->route('reservations.index')->with('error', 'La réservation est annulée et ne peut pas être validée.');
        }

        // Vérifier les conflits avec d'autres réservations validées pour la même salle
        $conflictingReservations = Reservation::where('salle_id', $reservation->salle_id)
            ->where('id', '!=', $reservation->id) // Exclure la réservation actuelle
            ->where('status', 'validé') // Seulement les réservations déjà validées
            ->where(function ($query) use ($reservation) {
                $query->whereBetween('start_time', [$reservation->start_time, $reservation->end_time])
                    ->orWhereBetween('end_time', [$reservation->start_time, $reservation->end_time])
                    ->orWhere(function ($query) use ($reservation) {
                        $query->where('start_time', '<=', $reservation->start_time)
                            ->where('end_time', '>=', $reservation->end_time);
                    });
            })->get();

        if ($conflictingReservations->isNotEmpty()) {
            $conflictDetails = $conflictingReservations->map(function ($conflict) {
                return "Du ".$conflict->start_time." au ".$conflict->end_time;
            })->implode(', ');

            return redirect()->route('reservations.index')->with('error',
                "Impossible de valider : conflit avec une réservation validée existante (".$conflictDetails.")")->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
        }

        // Mettre à jour le statut de la réservation
        $reservation->update(['status' => 'validé']);

        return redirect()->route('reservations.index')->with('success', 'Réservation validée avec succès.')->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

        public function annuler(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('cancel', $reservation); //autorisation via plicies

        // Vérifier si la réservation peut être annulée (par exemple, si elle n'est pas déjà validée)
        if ($reservation->status === 'validé') {
            return redirect()->route('reservations.index')->with('error', 'La réservation est déjà validée et ne peut pas être annulée.');
        }

        // Mettre à jour le statut de la réservation
        $reservation->update(['status' => 'annulé']);

        return redirect()->route('reservations.index')->with('success', 'Réservation annulée avec succès.');
    }


}
