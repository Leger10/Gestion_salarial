<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationCode;

    public function __construct(User $user, $verificationCode)
    {
        $this->user = $user;
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->subject('Vérification de votre compte')
                   ->view('emails.verification_code');
    }
}