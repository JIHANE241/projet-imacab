<?php

namespace App\Notifications;

use App\Models\Entretien;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NouvelEntretien extends Notification
{
    use Queueable;

    protected $entretien;

    public function __construct(Entretien $entretien)
    {
        $this->entretien = $entretien;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'entretien_id' => $this->entretien->id,
            'offre_titre' => $this->entretien->candidature->offre->titre,
            'date' => $this->entretien->date->format('d/m/Y'),
            'heure' => $this->entretien->heure->format('H:i'),
            'lieu' => $this->entretien->lieu,
            'message' => 'Un entretien a été planifié pour l\'offre '.$this->entretien->candidature->offre->titre.'.',
            'type' => 'entretien',
        ];
    }
}