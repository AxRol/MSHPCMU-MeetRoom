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

use App\Notifications\ReservationCreated;
use App\Notifications\ReservationValidated;
use App\Notifications\ReservationCanceled;
use App\Notifications\ReservationTerminated;
use App\Notifications\ReservationStatusChanged;
use Carbon\Carbon;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $this->authorize('viewAny', Reservation::class); // Autorisation via policies
        // Mettre à jour les réservations expirées et terminées
        $this->updateExpiredReservations();
        $this->updateCompletedReservations();

        $status = $request->query('status'); // Récupérer le statut depuis la requête
        $userId = Auth::id();

        if (Auth::check() && Auth::user()->hasRole('utilisateur')) {
            $query = Reservation::where('user_id', $userId);

            if ($status) {
                $query->where('status', $status);
            }

            $reservationsUser = $query->where('status', '!=', 'terminé')
                                    ->orderBy('start_time', 'desc')
                                    ->get();

            return view('reservations.index', compact('reservationsUser'));
        }
        if (Auth::check() && Auth::user()->hasRole('gestionnaire')) {
            $reservationGestionnaire = Reservation::whereIn('salle_id', Auth::user()->salles->pluck('id'))
                ->when($status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->orderBy('start_time', 'desc')
                ->get();

            return view('reservations.index', compact('reservationGestionnaire'));
        }

        $query = Reservation::with(['salle', 'user', 'direction']);

        if ($status) {
            $query->where('status', $status);
        }

        $reservations = $query->orderBy('start_time', 'desc')
                            ->get();

        return view('reservations.index', compact('reservations'));
    }



    /**
     * Show the form for creating a new reservation.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $this->authorize('create', Reservation::class); //autorisation via policies
        $salle_id = $request->input('salle_id');
        // Vérifier le rôle de l'utilisateur
        if ($user->hasRole('gestionnaire')) {
            $salles = $user->salles;
        } else {
            $salles = Salle::all();
        }
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
        'salle_id' => 'required|exists:salles,id',
        'direction_id' => 'required|exists:directions,id',
        'start_time' => 'required|date|after_or_equal:today',
        'end_time' => 'required|date|after:start_time',
        'user_id' => 'required|exists:users,id',
        ]);

        // CONTRAINTE : la réservation doit être sur un seul jour
        if (date('Y-m-d', strtotime($request->start_time)) !== date('Y-m-d', strtotime($request->end_time))) {
            return back()->withInput()->withErrors(['end_time' => 'La réservation doit commencer et finir le même jour.']);
        }

        $sallenom = 'Non spécifiée';

        $reservation = Reservation::create($request->all());
            //   $request->user()->notify(new ReservationCreated($reservation));

            if ($reservation->salle) {
                $sallenom = $reservation->salle->nom;
            }

        // Envoyer la notification de création
        $user = User::find($request->user_id);
        $user->notify(new ReservationCreated($reservation));

        // Notifier également les administrateurs
        $admins = User::role('administrateur')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ReservationCreated($reservation));
        }
        // Notifier également les gestionnaires
        $gestionnaires = User::role('gestionnaire')->get();
        foreach ($gestionnaires as $gestionnaire) {
            $gestionnaire->notify(new ReservationCreated($reservation));
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
      //  dd($request->all()); // Vérifiez les données reçues
        $this->validate($request, [
        'salle_id' => 'required|exists:salles,id',
        'direction_id' => 'required|exists:directions,id',
        'start_time' => 'required|date|after_or_equal:today',
        'end_time' => 'required|date|after:start_time',
        'user_id' => 'required|exists:users,id',
        'priority' => 'boolean'
        ]);
        // CONTRAINTE : la réservation doit être sur un seul jour
        if (date('Y-m-d', strtotime($request->start_time)) !== date('Y-m-d', strtotime($request->end_time))) {
            return back()->withInput()->withErrors(['end_time' => 'La réservation doit commencer et finir le même jour.']);
        }
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



    public function valider(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('validate', $reservation);

        // Vérifier si la réservation peut être validée
        if ($reservation->status === 'annulé') {
            return redirect()->route('reservations.index')->with('error', 'La réservation est annulée et ne peut pas être validée.');
        }

        // Trouver toutes les réservations en conflit pour la même salle
        $conflictingReservations = Reservation::where('salle_id', $reservation->salle_id)
            ->where('id', '!=', $reservation->id)
            ->where(function($query) {
                $query->where('status', 'validé')
                    ->orWhere('status', 'en attente');
            })
            ->where(function ($query) use ($reservation) {
                $query->whereBetween('start_time', [$reservation->start_time, $reservation->end_time])
                    ->orWhereBetween('end_time', [$reservation->start_time, $reservation->end_time])
                    ->orWhere(function ($query) use ($reservation) {
                        $query->where('start_time', '<=', $reservation->start_time)
                            ->where('end_time', '>=', $reservation->end_time);
                    });
            })->get();

        // Si réservation prioritaire
        if ($reservation->priority) {
            foreach ($conflictingReservations as $conflict) {
                // Mettre en attente les réservations en conflit
                $conflict->update(['status' => 'en attente']);
                $conflict->user->notify(new ReservationStatusChanged($reservation));
    /*             $conflict->user->notify(new ReservationStatusChanged(
                    'Votre réservation a été mise en attente',
                    'Une réservation prioritaire a été validée pour cette plage horaire.'
                )); */
            }
        }

        // Si réservation non prioritaire
        else {
            // Vérifier s'il existe des réservations validées en conflit
            $validatedConflicts = $conflictingReservations->where('status', 'validé');

            if ($validatedConflicts->isNotEmpty()) {
                $conflictDetails = $validatedConflicts->map(function ($conflict) {
                    return "Du ".$conflict->start_time->format('d/m/Y H:i')." au ".$conflict->end_time->format('d/m/Y H:i');
                })->implode(', ');

                return redirect()->route('reservations.index')->with('error',
                    "Impossible de valider : conflit avec une réservation validée existante (".$conflictDetails.")");
            }

        }

        // Mettre à jour le statut de la réservation
        $reservation->update(['status' => 'validé']);

        // Envoyer la notification de validation
        $reservation->user->notify(new ReservationValidated($reservation));

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation validée avec succès.')
            ->withHeaders([
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

        // Envoyer la notification d'annulation
        $reservation->user->notify(new ReservationCanceled($reservation));

        return redirect()->route('reservations.index')->with('success', 'Réservation annulée avec succès.');
    }

    protected function updateCompletedReservations()
    {
        // Récupérer les réservations validées dont la date de fin est passée
        $completedReservations = Reservation::where('status', 'validé')
            ->where('end_time', '<', Carbon::now())
            ->get();

        foreach ($completedReservations as $reservation) {
            // Mettre à jour le statut à "terminé"
            $reservation->update(['status' => 'terminé']);

            // Envoyer une notification si nécessaire
            $reservation->user->notify(new ReservationTerminated($reservation));
        }
    }
     /**
     * Met à jour les réservations "en attente" dont la date de fin est dépassée depuis plus d'une semaine
     */
    protected function updateExpiredReservations()
    {
        // Date limite : aujourd'hui moins une semaine
        $oneWeekAgo = Carbon::now()->subWeek();

        // Récupérer les réservations en attente dont la date de fin est antérieure à cette date
        $expiredReservations = Reservation::where('status', 'en attente')
            ->where('end_time', '<', $oneWeekAgo)
            ->get();

        foreach ($expiredReservations as $reservation) {
            // Mettre à jour le statut
            $reservation->update(['status' => 'archivé']);

            // Envoyer une notification si nécessaire
            $reservation->user->notify(new ReservationTerminated($reservation));
        }
    }


}
