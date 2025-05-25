<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminCreatedNotification extends Notification
{
    protected $verificationCode;
    protected $user;

    public function __construct($verificationCode, $user)
    {
        $this->verificationCode = $verificationCode;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];  // Utilise uniquement l'email pour cette notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Vérification de votre compte administrateur')
                    ->greeting('Bonjour ' . $this->user->name)
                    ->line('Voici votre code de vérification : ' . $this->verificationCode)
                    ->action('Définir votre mot de passe', url('/validate-account/' . $this->verificationCode . '/' . $this->user->email))
                    ->line('Merci de votre inscription !');
    }
}
