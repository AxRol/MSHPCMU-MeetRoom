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

    /**
     * Create a new notification instance.
     *
     * @param Reservation $reservation
     */
    public function __construct(public Reservation $reservation)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
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
            ->subject('Nouvelle Réservation - ' . $this->reservation->salle->nom)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle réservation a été créée avec les détails suivants:')
            ->line('**Détails de la réservation:**')
            ->line('- Salle: ' . $this->reservation->salle->nom)
            ->line('- Date: ' . $startTime->format('d/m/Y'))
            ->line('- Heure de début: ' . $startTime->format('H:i'))
            ->line('- Heure de fin: ' . $endTime->format('H:i'))
            ->line('- Durée: ' . $duration)
            ->line('- Crée par: ' . $this->reservation->user->name)
          //  ->action('Voir la réservation', url('/reservations/'.$this->reservation->id))
            ->line('Pour toute modification, veuillez contacter le gestionnaire de la salle.')
            ->salutation('Cordialement,');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'salle' => $this->reservation->salle->nom,
            'start_time' => $this->reservation->start_time,
            'end_time' => $this->reservation->end_time,
            'user' => $this->reservation->user->name,
        ];
    }
}
