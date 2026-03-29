<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        // Rediriger vers la page cible
        $data = $notification->data;
        if ($data['type'] == 'candidature') {
            return redirect()->route('candidat.candidatures.show', $data['candidature_id']);
        } elseif ($data['type'] == 'entretien') {
            return redirect()->route('candidat.entretiens.show', $data['entretien_id']);
        }
        return back();
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}