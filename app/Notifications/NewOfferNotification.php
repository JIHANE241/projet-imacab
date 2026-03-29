<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Offre;

class NewOfferNotification extends Notification
{
    use Queueable;

    protected $offre;

    public function __construct(Offre $offre)
    {
        $this->offre = $offre;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_offer',
            'title' => 'Nouvelle offre en attente de validation',
            'message' => "Une nouvelle offre '{$this->offre->titre}' a été créée par le responsable et attend votre validation.",
            'offre_id' => $this->offre->id,
            'url' => route('admin.offres.show', $this->offre),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle offre à valider')
            ->line("Une nouvelle offre '{$this->offre->titre}' a été créée.")
            ->action('Voir l\'offre', route('admin.offres.show', $this->offre))
            ->line('Merci de la valider pour la rendre visible aux candidats.');
    }
}