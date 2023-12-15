<?php

namespace App\Mail;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWelcomeUser extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $plan;


    public function __construct(User $user, Plan $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Obrigado por se registrar',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.welcomeTemplate',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
