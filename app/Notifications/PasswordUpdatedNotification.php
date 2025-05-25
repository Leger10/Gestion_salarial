<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        // Initialisez les propriétés si nécessaire
    }

    public function via($notifiable)
    {
        return ['mail']; // Indique que la notification sera envoyée par email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Mot de passe mis à jour')
            ->line('Votre mot de passe a été mis à jour avec succès.')
            ->action('Se connecter', url('/login'))
            ->line('Si vous n\'êtes pas à l\'origine de cette mise à jour, veuillez contacter le support.');
    }

    // Vous pouvez aussi implémenter d'autres méthodes pour gérer d'autres canaux de notification (par exemple, base de données, SMS, etc.)
}
