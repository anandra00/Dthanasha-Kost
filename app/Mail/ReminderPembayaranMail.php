<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderPembayaranMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tagihan;
    public $sisaHari;

    // KACAMATA SKEPTIS: Lempar data tagihan sama hitungan sisa harinya ke konstruktor
    public function __construct($tagihan, $sisaHari)
    {
        $this->tagihan = $tagihan;
        $this->sisaHari = $sisaHari;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[PENTING] Pengingat Tagihan Kos - {$this->tagihan->periode_bulan}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reminder-pembayaran', // Bikin view html emailnya nanti
        );
    }
}