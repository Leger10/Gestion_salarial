<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $url;

    public function __construct($nom, $email, $password, $prenom)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->url = url('/login'); // ou une URL personnalisée
    }

    public function build()
    {
        return $this->subject('Vos identifiants de connexion')
                    ->view('emails.user_password')
                    ->with([
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                        'email' => $this->email,
                        'password' => $this->password,
                        'url' => $this->url,
                    ]);
    }
}
