<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationCanceled extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Instance de la réservation
     * @var Reservation
     */
    public $reservation;

    /**
     * Création d'une nouvelle instance de notification
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Détermine les canaux de livraison
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Contenu de l'email
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $startTime = Carbon::parse($this->reservation->start_time);
        $endTime = Carbon::parse($this->reservation->end_time);
        $duration = $startTime->diffInHours($endTime) . ' heure(s)';

        return (new MailMessage)
            ->subject('Annulation de votre réservation - ' . $this->reservation->salle->nom)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Nous vous informons que votre réservation a été annulée.')
            ->line('**Détails de la réservation annulée:**')
            ->line('- Salle: ' . $this->reservation->salle->nom)
            ->line('- Date: ' . $startTime->format('d/m/Y'))
            ->line('- Créneau: ' . $startTime->format('H:i') . ' - ' . $endTime->format('H:i'))
            ->line('- Durée prévue: ' . $duration)
            ->line('')
            ->line('Si vous n\'êtes pas à l\'origine de cette annulation ou si vous pensez qu\'il s\'agit d\'une erreur,')
            ->line('veuillez contacter le gestionnaire de la salle au plus vite.')
          //  ->action('Voir le détail de la réservation', url('/reservations/'.$this->reservation->id))
            ->line('')
            ->salutation('Cordialement.');
    }
}
