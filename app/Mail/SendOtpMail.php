<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    // Kacamata Skeptis: Deklarasikan public biar otomatis bisa dibaca di Blade tanpa ribet with()
    public $otpCode;
    public $nama;

    public function __construct($otpCode, $nama)
    {
        $this->otpCode = $otpCode;
        $this->nama = $nama;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP Verifikasi Email - Dthanasha Kost',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp', // Arahin ke folder resources/views/emails/otp.blade.php
        );
    }

    public function attachments(): array
    {
        return [];
    }
}