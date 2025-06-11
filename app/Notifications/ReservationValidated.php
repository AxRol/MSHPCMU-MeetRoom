<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;
use Carbon\Carbon;

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
        $startTime = Carbon::parse($this->reservation->start_time);
        $endTime = Carbon::parse($this->reservation->end_time);
        $duration = $startTime->diffInHours($endTime) . ' heure(s)';

        return (new MailMessage)
            ->subject('Confirmation de réservation - ' . config('app.name'))
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Nous vous confirmons que votre réservation a bien été enregistrée.')
            ->line('**Détails de la réservation :**')
            ->line('- Salle : ' . $this->reservation->salle->nom)
            ->line('- Date : ' . $startTime->locale('fr')->translatedFormat('l j F Y'))
            ->line('- Horaires : ' . $startTime->format('H:i') . ' - ' . $endTime->format('H:i'))
            ->line('- Durée : ' . $duration)
           // ->action('Voir ma réservation', route('reservations.show', $this->reservation->id))
            // ->line('Pour toute modification, veuillez nous contacter à l\'adresse ' . config('mail.from.address'))
            ->salutation('Cordialement,');
    }
}
