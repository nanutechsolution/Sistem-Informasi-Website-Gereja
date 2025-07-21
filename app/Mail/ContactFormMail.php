<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address; // Tambahkan ini untuk Address

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $message_content; // Hindari konflik dengan $message bawaan PHP

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $message_content)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message_content = $message_content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')), // Gunakan dari .env
            replyTo: [
                new Address($this->email, $this->name), // Agar bisa langsung balas ke pengirim
            ],
            subject: 'Pesan Baru dari Formulir Kontak Website Gereja',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form', // View Blade untuk isi email
            with: [
                'userName' => $this->name,
                'userEmail' => $this->email,
                'userMessage' => $this->message_content,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // Jika tidak ada lampiran
    }
}
