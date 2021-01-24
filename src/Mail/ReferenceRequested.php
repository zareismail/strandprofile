<?php

namespace Zareismail\Strandprofile\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReferenceRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $reference;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                    ->from($this->reference->auth->email)
                    ->markdown('references::emails.request');
    }
}
