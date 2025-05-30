<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationTerminated extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['mail']; // ou seulement 'database' si vous ne voulez pas d'email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Votre réservation a été archivée')
                    ->line('Votre réservation pour la salle ' . $this->reservation->salle->nom . ' a été marquée comme terminée et archivée.')
                    ->line('Date: ' . $this->reservation->start_time . ' - ' . $this->reservation->end_time)
                    ->action('Voir les réservations', url('/reservations'))
                    ->line('Merci d\'utiliser notre service!');
    }

}
