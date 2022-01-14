<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketReply extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $reply,$by;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $reply,$by)
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
        $this->by =$by;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.master.ticket_reply',
            [
                "reply" => $this->reply,
                'ticket' =>  $this->ticket,
                "by" => $this->by
            ]
        );
    }
}
