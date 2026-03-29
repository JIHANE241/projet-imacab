<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Candidature;
use App\Models\User;

class CandidatureCommented extends Notification
{
    use Queueable;

    protected $candidature;
    protected $responsable;

    public function __construct(Candidature $candidature, User $responsable)
    {
        $this->candidature = $candidature;
        $this->responsable = $responsable;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

public function toDatabase($notifiable)
{
    return [
        'type' => 'candidature_commented', 
        'title' => 'Nouveau commentaire sur une candidature',
        'message' => "{$this->responsable->name} a commenté la candidature pour '{$this->candidature->offre->titre}'",
        'candidature_id' => $this->candidature->id,
        'url' => route('admin.candidatures.show', $this->candidature),
    ];
}

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("{$this->responsable->name} a commenté la candidature pour '{$this->candidature->offre->titre}'.")
            ->action('Voir la candidature', route('admin.candidatures.show', $this->candidature))
            ->line('Merci de prendre connaissance de cet avis.');
    }
}