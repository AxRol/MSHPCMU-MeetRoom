<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Salle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
{
    $userId = Auth::id();

    $today = Carbon::today();
    $totalUsers = User::count();
    $totalSalles = Salle::count();
    $totalReservations = Reservation::count();
    $totalReservationsUser = Reservation::where('user_id', $userId)->count();
    $reservationsEnAttente = Reservation::where('status', 'en attente')->count();
    $reservationsValidees = Reservation::where('status', 'validé')->count();
    $reservationsAnnulees = Reservation::where('status', 'annulé')->count();

    $totalReservationsDuJourUser = Reservation::where('user_id', $userId)
        ->where('start_time', $today)
        ->count();
    $totalReservationsDuJour = Reservation::whereDate('start_time', $today)->count();

    // Taux d'utilisation des salles
    $reservationsParSalle = Salle::withCount('reservations')->get();
    // Préparer les données pour le graphique
    $labels_reserv_salle = $reservationsParSalle->pluck('nom'); // Noms des salles
    $data_reserv_salle = $reservationsParSalle->pluck('reservations_count'); // Nombre de réservations
    $data_pourcentage_salle = $reservationsParSalle->map(function ($salle) use ($totalReservations) {
        return ($salle->reservations_count / $totalReservations) * 100; // Pourcentage
    });

    $allReservationUser = Reservation::where('user_id', $userId)
        ->orderBy('start_time', 'desc') // Optionnel : trier par date de début
        ->get();

    $currentReservationsUser = Reservation::where('user_id', $userId)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->count();

    $reservationsByDayUser = Reservation::where('user_id', $userId)
        ->whereBetween('start_time', [
            Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->with('salle') // Charger la relation "salle"
        ->get()
        ->groupBy(function ($reservation) {
            return Carbon::parse($reservation->start_time)->format('l'); // Grouper par jour de la semaine
        })
        ->map(function ($group) {
            return $group->count(); // Compter le nombre de réservations par jour
        });

    $currentReservations = Reservation::where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->count();

    // Nombre de salles en cours d'utilisation
    $sallesEnCoursUtilisation = Reservation::where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->distinct('salle_id') // Récupérer les salles uniques
        ->count('salle_id'); // Compter le nombre de salles

    $latestReservations = Reservation::whereBetween('start_time', [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek()
    ])->orderBy('start_time', 'desc')->paginate(10);

    $topDirections = Reservation::select('directions.nom as direction')
        ->join('directions', 'reservations.direction_id', '=', 'directions.id')
        ->selectRaw('count(*) as total')
        ->groupBy('directions.nom')
        ->orderBy('total', 'desc')
        ->limit(5)
        ->get();
    $totalReservationsByDirection = $topDirections->sum('total'); // Total des réservations pour toutes les directions
    $topDirections = $topDirections->map(function ($direction) use ($totalReservationsByDirection) {
        $direction->percentage = ($direction->total / $totalReservationsByDirection) * 100; // Calcul du pourcentage
        return $direction;
    });

    $reservationsByDay = Reservation::whereBetween('start_time', [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek()
    ])->with('salle')
        ->get()
        ->groupBy(function ($reservation) {
            return Carbon::parse($reservation->start_time)->format('l'); // Grouper par jour de la semaine
        })
        ->map(function ($group) {
            return $group->count(); // Compter le nombre de réservations par jour
        });

    $labels = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    $data = collect($labels)->map(function ($day) use ($reservationsByDay) {
        return $reservationsByDay->get($day, 0); // Récupérer le nombre de réservations pour chaque jour
    });

    $reservations_agenda = Reservation::all();
    $reservationsForCalendar = $this->formatReservationsForCalendar($reservations_agenda);

  ////  $salles = Salle::all(); // Assurez-vous d'avoir le modèle Salle et le use en haut
    //$today = now()->format('Y-m-d');

    //// Charger toutes les salles avec leurs réservations en cours
    //$salles = Salle::with(['reservations' => function($query) {
      //  $query->where('start_time', '<=', now())
        //      ->where('end_time', '>=', now())
          //    ->where('status', 'validé');
   // }])->get();

    //// Séparer les salles disponibles et occupées
    //$sallesDisponibles = $salles->filter(function($salle) {
    //    return $salle->reservations->isEmpty();
    //});
    //
    //$sallesOccupees = $salles->filter(function($salle) {
    //    return $salle->reservations->isNotEmpty();
    //});

    $now = now();

    $salles = Salle::with(['reservations' => function($query) use ($now) {
        $query->where('start_time', '<=', $now)
              ->where('end_time', '>=', $now)
              ->where('status', 'validé')
              ->with('user'); // Charger aussi l'utilisateur
    }])->orderBy('nom')->get();

    // Préparer les données de disponibilité
    $salles->each(function($salle) {
        $salle->estDisponible = $salle->reservations->isEmpty();
        $salle->reservationActuelle = $salle->reservations->first();
    });


    return view('dashboard.index', compact(
        'totalUsers',
        'totalSalles',
        'totalReservations',
        'totalReservationsUser',
        'totalReservationsDuJourUser',
        'allReservationUser',
        'currentReservationsUser',
        'reservationsByDayUser',
        'currentReservations',
        'sallesEnCoursUtilisation',
        'latestReservations',
        'topDirections',
        'totalReservationsByDirection',
        'reservationsByDay',
        'labels',
        'data',
        'labels_reserv_salle',
        'data_reserv_salle',
        'data_pourcentage_salle',
        'totalReservationsDuJour',
        'reservationsForCalendar',
        'reservationsEnAttente',
        'reservationsValidees',
        'reservationsAnnulees',
        'salles',
    //    'sallesDisponibles',
    //    'sallesOccupees'
    //    'reservationsDuJour'
        'now'
    ));
}

    private function formatReservationsForCalendar($reservations)
    {
        return $reservations->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'title' => $reservation->salle->nom . ' - ' . $reservation->motif, // Titre de l'événement
                //'title' => $reservation->salle->nom . ' - ' . $reservation->direction->nom, // Titre de l'événement
                'start' => $reservation->start_time, // Date et heure de début
                'end' => $reservation->end_time, // Date et heure de fin
                'backgroundColor' => $this->getEventColor($reservation->status), // Couleur en fonction du statut
               // 'borderColor' => '#000', // Couleur de la bordure
                'textColor' => '#000000', // Couleur du texte
            ];
        })->toArray();
    }

    /**
    * Retourne la couleur de l'événement en fonction du statut.
    *
    * @param string $status
    * @return string
    */
    private function getEventColor($status)
    {
        switch ($status) {
            case 'validé':
                return '#2eca6a'; // Vert
            case 'annulé':
                return '#fe0303'; // Rouge
            case 'en attente':
                return '#3c44f4'; // orange
            default:
                return '#bff4f7'; // Bleu par défaut
        }
    }
}
