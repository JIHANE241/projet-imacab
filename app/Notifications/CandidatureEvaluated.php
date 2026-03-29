<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Candidature; 
use App\Models\User;

class CandidatureEvaluated extends Notification
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
            'type' => 'candidature_evaluated',
            'title' => 'Évaluation d\'une candidature',
            'message' => "{$this->responsable->name} a évalué la candidature pour '{$this->candidature->offre->titre}' comme " . ($this->candidature->evaluation == 'favorable' ? 'favorable' : 'défavorable'),
            'candidature_id' => $this->candidature->id,
            'url' => route('admin.candidatures.show', $this->candidature),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle évaluation de candidature')
            ->line("{$this->responsable->name} a évalué la candidature pour '{$this->candidature->offre->titre}'.")
            ->line("Avis : " . ($this->candidature->evaluation == 'favorable' ? 'Favorable' : 'Défavorable'))
            ->line("Commentaire : " . ($this->candidature->evaluation_comment ?? 'Aucun commentaire'))
            ->action('Voir la candidature', route('admin.candidatures.show', $this->candidature));
    }
}