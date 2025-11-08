<?php

namespace Modules\LMS\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected $details)
    {
        //
        $this->details = $details;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->to($this->details['email']) // Set recipient here
            ->subject($this->details['subject'])
            ->html($this->details['body']); // Use raw HTML

    }
}
