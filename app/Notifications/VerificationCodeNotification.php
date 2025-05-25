<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerificationCodeNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $verificationCode;

    public function __construct($user, $verificationCode)
    {
        $this->user = $user;
        $this->verificationCode = $verificationCode;
    }

    public function via($notifiable)
    {
        return ['mail'];  // La notification sera envoyée par mail
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Vérification de votre compte administrateur')
                    ->greeting('Bonjour ' . $this->user->name)  // Salutation avec le nom de l'utilisateur
                    ->line('Voici votre code de vérification : ' . $this->verificationCode)  // Ligne avec le code
                    ->action('Définir votre mot de passe', url('/defineAccess/' . $this->verificationCode . '/' . $this->user->email))  // Lien vers la page de validation
                    ->line('Merci de votre inscription !');  // Message de clôture
    }
}
