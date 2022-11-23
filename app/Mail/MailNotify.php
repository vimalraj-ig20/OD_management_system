<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $data1 = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data1)
    {
        $this->data = $data1;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('camps@bitsathy.ac.in', 'Leave Portal')
                    ->subject($this->data['subject'])->view('email.email')->with('data', $this->data);
    }
}
