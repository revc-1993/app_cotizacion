<?php

namespace App\Mail;

use App\Models\Configuration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailStoreQuote extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfData;

    public function __construct($pdfData)
    {
        $this->pdfData = $pdfData;
    }

    public function build()
    {
        $configuration = Configuration::all()->first();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf-quote', $this->pdfData);

        return $this->from($configuration->mail_from_address, $configuration->mail_from_name)
            ->subject("Cotización - " . $configuration->company_name . " - " . now())
            ->view('emails.create_quote')
            ->attachData($pdf->output(), now() . '.pdf');
    }
}
