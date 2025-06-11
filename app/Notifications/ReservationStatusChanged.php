<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * L'instance de réservation
     * @var Reservation
     */
    public $reservation;

    /**
     * Crée une nouvelle instance de notification
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
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

        return (new MailMessage)
            ->subject('Mise à jour de votre réservation - ' . $this->reservation->salle->nom)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre réservation pour la salle **' . $this->reservation->salle->nom . '** a été mise en attente.')
            ->line('**Raison :** Une réservation prioritaire a été validée pour cette plage horaire.')
            ->line('**Détails de la réservation affectée :**')
            ->line('- Date : ' . $startTime->format('d/m/Y'))
            ->line('- Heure : ' . $startTime->format('H:i') . ' - ' . $endTime->format('H:i'))
          /*   ->action('Voir le détail de votre réservation',url()->to('http://' . getHostByName(getHostName()) . ':8000/reservations/' . $this->reservation->id))
            ->action('Aller au tableau de bord', url()->to('http://' . getHostByName(getHostName()) . ':8000/dashboard#reservation-section')) */
            ->line('Nous vous informerons si cette réservation peut être confirmée.')
            ->line('Pour toute question, veuillez contacter notre support.')
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
            'status' => 'en_attente',
            'message' => 'Mise en attente due à une réservation prioritaire'
        ];
    }
}
