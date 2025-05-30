<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Reservation $reservation)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Formatage des dates avec gestion d'erreur
        $startTime = $this->reservation->start_time instanceof \DateTime
            ? $this->reservation->start_time
            : Carbon::parse($this->reservation->start_time);

        $endTime = $this->reservation->end_time instanceof \DateTime
            ? $this->reservation->end_time
            : Carbon::parse($this->reservation->end_time);

        return (new MailMessage)
            ->subject('Nouvelle Réservation Créée')
            ->line('Une nouvelle réservation a été créée.')
            ->line('Salle: ' . $this->reservation->salle->nom)
            ->line('Date: ' . $this->reservation->start_time . ' - ' . $this->reservation->end_time)
            ->line('Responsable: ' . $this->reservation->user->name)
            ->action('Voir la réservation', url(':8000/reservations/'.$this->reservation->id))
            ->line('Merci d\'utiliser notre application!');
    }
}
