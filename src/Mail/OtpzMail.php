<?php

namespace BenBjurstrom\Otpz\Mail;

use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
            subject: 'Sign in to '.config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $email = $this->otp->user->email;

        // Format the code with hyphen in the middle for readability
        $midpoint = (int) (strlen($this->code) / 2);
        $formattedCode = substr_replace($this->code, '-', $midpoint, 0);

        $template = config('otpz.template', 'otpz::mail.otpz');

        return new Content(
            markdown: $template,
            with: [
                'email' => $email,
                'code' => $formattedCode,
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
