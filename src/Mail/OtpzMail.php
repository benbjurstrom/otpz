<?php

namespace BenBjurstrom\Otpz\Mail;

use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class OtpzMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected Otp $otp, protected string $code)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Secure '.config('app.name').' Login Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $url = URL::temporarySignedRoute('otp.show', now()->addMinutes(5), [
            'id' => $this->otp->id,
            'session' => request()->session()->getId(),
        ]);

        $template = config('otpz.template', 'otpz::mail.otpz');

        return new Content(
            markdown: $template,
            with: [
                'url' => $url,
                'code' => $this->code,
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
        return [];
    }
}
