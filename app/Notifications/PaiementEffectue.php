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
    public $salaire_net;

    public function __construct($employer, $payment, $month, $year, $salaire_net)
    {
        $this->employer = $employer;
        $this->payment = $payment;
        $this->month = $month;
        $this->year = $year;
        $this->salaire_net = $salaire_net;
    }

    public function build()
    {
        return $this->subject("Confirmation de paiement - {$this->month} {$this->year}")
                    ->view('emails.payment-confirmation')
                    ->with([
                        'employer'     => $this->employer,
                        'payment'      => $this->payment,
                        'month'        => $this->month,
                        'year'         => $this->year,
                        'salaire_net'  => $this->salaire_net,
                    ]);
    }
}
