<?php

namespace App\Notifications;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidatureStatutChange extends Notification implements ShouldQueue
{
    use Queueable;

    protected $candidature;

    public function __construct(Candidature $candidature)
    {
        $this->candidature = $candidature;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $statut = $this->candidature->statut;
        $message = match($statut) {
            'acceptee' => 'Félicitations ! Votre candidature pour '.$this->candidature->offre->titre.' a été acceptée.',
            'refusee' => 'Votre candidature pour '.$this->candidature->offre->titre.' n\'a pas été retenue.',
            default => 'Le statut de votre candidature pour '.$this->candidature->offre->titre.' a été mis à jour.',
        };

        return [
            'candidature_id' => $this->candidature->id,
            'offre_titre' => $this->candidature->offre->titre,
            'message' => $message,
            'statut' => $statut,
            'type' => 'candidature',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Le statut de votre candidature a changé.')
                    ->action('Voir ma candidature', url('/candidat/candidatures/'.$this->candidature->id))
                    ->line('Merci de votre confiance !');
    }
}