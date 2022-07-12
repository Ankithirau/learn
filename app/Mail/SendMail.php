<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $update;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($update)
    {
        $this->update = $update;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $this->details['subject']
        return $this->subject('Reset your password')
            ->view('email.reset_password');
    }
}
