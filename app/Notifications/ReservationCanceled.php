<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationCanceled extends Notification implements ShouldQueue
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
            ->subject('Réservation Annulée')
            ->line('Votre réservation a été annulée.')
            ->line('Salle: ' . $this->reservation->salle->nom)
            ->line('Date: ' . $this->reservation->start_time . ' - ' . $this->reservation->end_time)
        //    ->line('Date: ' . $this->reservation->start_time->format('d/m/Y H:i') . ' - ' . $this->reservation->end_time->format('H:i'))
            ->line('Si vous pensez qu\'il s\'agit d\'une erreur, veuillez contacter l\'administrateur.')
            ->action('Voir la réservation', url(':8000/reservations/'.$this->reservation->id))
            ->line('Merci d\'utiliser notre application!');
    }
}
