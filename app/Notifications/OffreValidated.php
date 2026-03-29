<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Offre;

class OffreValidated extends Notification
{
    use Queueable;

    protected $offre;

    public function __construct(Offre $offre)
    {
        $this->offre = $offre;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'offre_validee',
            'title' => 'Votre offre a été validée',
            'message' => "L'offre '{$this->offre->titre}' est maintenant visible par les candidats.",
            'offre_id' => $this->offre->id,
            'url' => route('responsable.offres.show', $this->offre),
        ];
    }
}
