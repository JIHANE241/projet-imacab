<?php

namespace App\Notifications;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NouvelleCandidature extends Notification
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
        return [
            'candidature_id' => $this->candidature->id,
            'candidat_nom' => $this->candidature->candidat->name,
            'offre_titre' => $this->candidature->offre->titre,
            'message' => 'Nouvelle candidature de '.$this->candidature->candidat->name.' pour l\'offre '.$this->candidature->offre->titre.'.',
            'type' => 'nouvelle_candidature',
        ];
    }
}