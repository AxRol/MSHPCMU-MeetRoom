<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationValidated extends Notification implements ShouldQueue
{
    use Queueable;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $startTime = \Carbon\Carbon::parse($this->reservation->start_time);
        $endTime = \Carbon\Carbon::parse($this->reservation->end_time);

        return (new MailMessage)
            ->subject('Réservation Validée')
            ->line('Votre réservation a été validée.')
            ->line('Salle: ' . $this->reservation->salle->nom)
            ->line('Date: ' . $this->reservation->start_time . ' - ' . $this->reservation->end_time)
            ->action('Voir la réservation', url(':8000/reservations/'.$this->reservation->id))
            ->line('Merci d\'utiliser notre application!');
    }


}
