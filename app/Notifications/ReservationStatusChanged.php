<?php

// app/Notifications/ReservationStatusChanged.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reservation;

class ReservationStatusChanged extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    public $reservation;

    // public function __construct($title, $message)
    // {
    //     $this->title = $title;
    //     $this->message = $message;
    // }
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
        /* return (new MailMessage)
            ->subject($this->title)
            ->line($this->message)
            ->action('Voir les détails', url('/reservations'))
            ->line('Merci d\'utiliser notre application !'); */
        return (new MailMessage)
            ->subject('Réservation mise en attente')
            ->line('Votre réservation pour la salle ' . $this->reservation->salle->nom. 'a été mise en attente car une reservation prioritaire a été validée pour cette plage horaire.')
            ->action('Voir la réservation', url('/reservations/'.$this->reservation->id))
            ->line('Merci d\'utiliser notre application!');

    }
}
