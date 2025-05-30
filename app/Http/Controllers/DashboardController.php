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
        $user = Auth::user(); // Récupérer l'utilisateur connecté
        $userId = Auth::id();
        $now = Carbon::now();
       // $now = now();

        // Initialisation des variables
        $reservationsStats = [];
        $reservationsDuJour = 0;
        $reservationsEnCours = 0;
        $totalReservations = 0;
        $tauxOccupation = 0;
        $reservationsParSalle = [];
        $reservationsParDirection = [];
        $salles = [];
       // $reservationsForCalendar = [];
       $reservationsForCalendar = $this->formatReservationsForCalendar(Reservation::where('status', '!=', 'archivé')->get());
        $reservations = Reservation::all();
        $labels_reserv_salle = [];
        $data_reserv_salle = [];
        $data_pourcentage_salle = [];
        $topDirections = Reservation::select('directions.nom as direction')
            ->join('directions', 'reservations.direction_id', '=', 'directions.id')
            ->selectRaw('count(*) as total')
            ->groupBy('directions.nom')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $now = Carbon::now();
        Reservation::where('status', 'validé')
            ->where('end_time', '<', $now)
            ->update(['status' => 'terminé']);




        // Gestionnaire
        if ($user && $user->hasRole('gestionnaire')) {
            $sallesIds = $user->salles->pluck('id');

            // Statistiques des réservations
            $reservationsStats = Reservation::whereIn('salle_id', $sallesIds)
                ->selectRaw("
                    SUM(CASE WHEN status = 'validé' THEN 1 ELSE 0 END) as validees,
                    SUM(CASE WHEN status = 'annulé' THEN 1 ELSE 0 END) as annulees,
                    SUM(CASE WHEN status = 'en attente' THEN 1 ELSE 0 END) as en_attente,
                    SUM(CASE WHEN status = 'terminé' THEN 1 ELSE 0 END) as terminees,
                    SUM(CASE WHEN status = 'archivé' THEN 1 ELSE 0 END) as archivees
                ")
                ->first();

            $reservationsDuJour = Reservation::whereIn('salle_id', $sallesIds)
                ->whereDate('start_time', Carbon::today())
                ->count();

            $reservationsEnCours = Reservation::whereIn('salle_id', $sallesIds)
                ->where('start_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->count();

            $totalReservations = Reservation::whereIn('salle_id', $sallesIds)->count();

            $tauxOccupation = $totalReservations > 0
                ? ($reservationsEnCours / $totalReservations) * 100
                : 0;

            $reservationsParSalle = Salle::whereIn('id', $sallesIds)
                ->withCount('reservations')
                ->get();

            $reservationsParDirection = Reservation::whereIn('salle_id', $sallesIds)
                ->join('directions', 'reservations.direction_id', '=', 'directions.id')
                ->select('directions.nom as direction')
                ->selectRaw('count(*) as total')
                ->groupBy('directions.nom')
                ->orderBy('total', 'desc')
                ->get();

            $salles = Salle::whereIn('id', $sallesIds)
                ->with(['reservations' => function ($query) use ($now) {
                    $query->where('start_time', '<=', $now)
                        ->where('end_time', '>=', $now)
                        ->where('status', 'validé');
                }])
                ->get();

            $salles->each(function ($salle) {
                $salle->estDisponible = $salle->reservations->isEmpty();
                $salle->reservationActuelle = $salle->reservations->first();
            });

            $reservationsForCalendar = $this->formatReservationsForCalendar(
                Reservation::whereIn('salle_id', $sallesIds)
                ->where('status', '!=', 'archivé')
                ->get()
            );
            // Taux d'utilisation des salles
            $reservationsParSalle = Salle::whereIn('id', $sallesIds)->withCount('reservations')->get();
            // Préparer les données pour le graphique
            $labels_reserv_salle = $reservationsParSalle->pluck('nom'); // Noms des salles
            $data_reserv_salle = $reservationsParSalle->pluck('reservations_count'); // Nombre de réservations
            $data_pourcentage_salle = $reservationsParSalle->map(function ($salle) use ($totalReservations) {
                return ($salle->reservations_count / $totalReservations) * 100; // Pourcentage
            });
        }

        // Administrateur
        if ($user && $user->hasRole('administrateur')) {
            $reservationsStats = Reservation::selectRaw("
                SUM(CASE WHEN status = 'validé' THEN 1 ELSE 0 END) as validees,
                SUM(CASE WHEN status = 'annulé' THEN 1 ELSE 0 END) as annulees,
                SUM(CASE WHEN status = 'en attente' THEN 1 ELSE 0 END) as en_attente,
                SUM(CASE WHEN status = 'terminé' THEN 1 ELSE 0 END) as terminees,
                SUM(CASE WHEN status = 'archivé' THEN 1 ELSE 0 END) as archivees
            ")
            ->first();

            $reservationsDuJour = Reservation::whereDate('start_time', Carbon::today())->count();

            $reservationsEnCours = Reservation::where('start_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->count();

            $totalReservations = Reservation::count();

            $tauxOccupation = $totalReservations > 0
                ? ($reservationsEnCours / $totalReservations) * 100
                : 0;

            $reservationsParSalle = Salle::withCount('reservations')->get();

            $reservationsParDirection = Reservation::join('directions', 'reservations.direction_id', '=', 'directions.id')
                ->select('directions.nom as direction')
                ->selectRaw('count(*) as total')
                ->groupBy('directions.nom')
                ->orderBy('total', 'desc')
                ->get();

            $salles = Salle::with(['reservations' => function ($query) use ($now) {
                $query->where('start_time', '<=', $now)
                    ->where('end_time', '>=', $now)
                    ->where('status', 'validé');
            }])
            ->get();

            $salles->each(function ($salle) {
                $salle->estDisponible = $salle->reservations->isEmpty();
                $salle->reservationActuelle = $salle->reservations->first();
            });

            $reservationsForCalendar = $this->formatReservationsForCalendar(Reservation::all());

            // Taux d'utilisation des salles
            $reservationsParSalle = Salle::withCount('reservations')->get();
            // Préparer les données pour le graphique
            $labels_reserv_salle = $reservationsParSalle->pluck('nom'); // Noms des salles
            $data_reserv_salle = $reservationsParSalle->pluck('reservations_count'); // Nombre de réservations
            $data_pourcentage_salle = $reservationsParSalle->map(function ($salle) use ($totalReservations) {
                return ($salle->reservations_count / $totalReservations) * 100; // Pourcentage
            });
        }

        // Utilisateur
        if ($user && $user->hasRole('utilisateur')) {
            $reservationsStats = Reservation::where('user_id', $userId)
                ->selectRaw("
                    SUM(CASE WHEN status = 'validé' THEN 1 ELSE 0 END) as validees,
                    SUM(CASE WHEN status = 'annulé' THEN 1 ELSE 0 END) as annulees,
                    SUM(CASE WHEN status = 'en attente' THEN 1 ELSE 0 END) as en_attente,
                    SUM(CASE WHEN status = 'terminé' THEN 1 ELSE 0 END) as terminees,
                    SUM(CASE WHEN status = 'archivé' THEN 1 ELSE 0 END) as archivees
                ")
                ->first();

            $reservationsDuJour = Reservation::where('user_id', $userId)
                ->whereDate('start_time', Carbon::today())
                ->count();

            $reservationsEnCours = Reservation::where('user_id', $userId)
                ->where('start_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->count();

            $totalReservations = Reservation::where('user_id', $userId)->count();

            $reservationsForCalendar = $this->formatReservationsForCalendar(
                Reservation::where('user_id', $userId)
                ->where('status', '!=', 'archivé')
                ->get()
            );
        }

        return view('dashboard.index', compact(
            'reservationsStats',
            'reservationsDuJour',
            'reservationsEnCours',
            'totalReservations',
            'tauxOccupation',
            'reservationsParSalle',
            'reservationsParDirection',
            'salles',
            'reservationsForCalendar',
            'labels_reserv_salle',
            'data_reserv_salle', // Nombre de réservations
            'data_pourcentage_salle',
            'topDirections'
        ));
    }

    private function formatReservationsForCalendar($reservations)
    {
        $userId = Auth::id();
        return $reservations->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'title' => $reservation->salle->nom . ' - ' . $reservation->motif, // Titre de l'événement
                //'title' => $reservation->salle->nom . ' - ' . $reservation->direction->nom, // Titre de l'événement
                'start' => $reservation->start_time, // Date et heure de début
                'end' => $reservation->end_time, // Date et heure de fin
                'salle' => $reservation->salle->nom ?? 'Non spécifié',
                'direction' => $reservation->direction->nom ?? 'Non spécifié',
                'motif' => $reservation->motif ?? 'Non spécifié',
                'status' => $reservation->status ?? 'Non spécifié',
                'priority' => $reservation->priority ? 'Oui' : 'Non',
                'creator_id' => $reservation->user_id ?? null,
                'user_id' => $userId ?? null,
               //  'backgroundColor' => $this->getEventColor($reservation->status), // Couleur en fonction du statut
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

    public function getReservationsStatsForGestionnaire()
    {
        $user = Auth::user();
      // $userId = Auth::id();

        // Vérifier si l'utilisateur est un gestionnaire
        if (Auth::check() && Auth::user()->hasRole('gestionnaire')) {
            // Récupérer les salles assignées au gestionnaire
            $sallesIds = $user->salles->pluck('id');

            // Calculer les statistiques des réservations pour ces salles
            $stats = Reservation::whereIn('salle_id', $sallesIds)
                ->selectRaw("
                    SUM(CASE WHEN status = 'validé' THEN 1 ELSE 0 END) as validé,
                    SUM(CASE WHEN status = 'annulé' THEN 1 ELSE 0 END) as annulé,
                    SUM(CASE WHEN status = 'en attente' THEN 1 ELSE 0 END) as en_attente,
                    SUM(CASE WHEN status = 'terminé' THEN 1 ELSE 0 END) as termine
                ")
                ->first();

            return $stats;
        }

        return null; // Si l'utilisateur n'est pas un gestionnaire
    }
}
