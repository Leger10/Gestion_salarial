<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $employer;
    public $payment;
    public $month;
    public $year;

    // Supprimer $salaire_net du constructeur
    public function __construct($employer, $payment, $month, $year)
    {
        $this->employer = $employer;
        $this->payment = $payment;
        $this->month = $month;
        $this->year = $year;
    }

    public function build()
    {
        return $this->subject("Confirmation de paiement - {$this->month} {$this->year}")
                    ->view('emails.payment-confirmation')
                    ->with([
                        'salaire_net' => $this->payment->salaire_net // Récupérer depuis le paiement
                    ]);
    }
}