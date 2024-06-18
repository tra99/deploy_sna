<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    private $data = [];

    /**
    * Create a new message instance.
    */
    public function __construct( $data)
    {
        $this->data = $data;
    }
    /**
    * build the message
    * @return $this
    */
    public function build()
    {
        $data = $this->data;

        return $this->from($data['fromEmail'],$data['fromName'])
        ->subject($this->data['subject'])
        ->view('emailTemplate', compact('data'))
        ->with('data',$this->data);
    }
}
