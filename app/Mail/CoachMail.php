<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoachMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($postData)
    {
        $this->data = $postData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->view('emails.coach-mail')
                    ->from(env('FROM_EMAIL'), env('SITE_TITLE'))
                    ->subject('Request Email')
                    ->with([ 'data' => $this->data ]);
    }
}
