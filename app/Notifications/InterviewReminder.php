<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Entretien;
use Illuminate\Support\Facades\Auth;

class InterviewReminder extends Notification
{
    use Queueable;

    protected $interview;

    public function __construct(Entretien $interview)
    {
        $this->interview = $interview;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        
        $url = $this->getUrl($notifiable);

        return [
            'type' => 'interview_reminder',
            'title' => 'Rappel d\'entretien',
            'message' => "Entretien prévu aujourd'hui à {$this->interview->heure} pour le candidat {$this->interview->candidature->candidat->name} ({$this->interview->candidature->offre->titre}).",
            'interview_id' => $this->interview->id,
            'url' => $url,
        ];
    }

    public function toMail($notifiable)
    {
        $url = $this->getUrl($notifiable);

        return (new MailMessage)
            ->subject('Rappel d\'entretien')
            ->line("Un entretien est prévu aujourd'hui à {$this->interview->heure}.")
            ->line("Candidat : {$this->interview->candidature->candidat->name}")
            ->line("Offre : {$this->interview->candidature->offre->titre}")
            
            ->action('Voir l\'entretien', $url);
    }

    /**
     * Récupère l'URL appropriée selon le rôle de l'utilisateur
     */
    protected function getUrl($notifiable)
    {
       
        if (isset($notifiable->role) && $notifiable->role === 'admin') {
            return route('admin.entretiens.show', $this->interview);
        }

        
        return route('responsable.entretiens.show', $this->interview);
    }
}