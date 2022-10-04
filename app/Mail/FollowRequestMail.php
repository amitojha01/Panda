<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowRequestMail extends Mailable
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
        return $this->view('emails.follow-request')
                    ->from(env('FROM_EMAIL'), env('SITE_TITLE'))
                    ->subject('Follow Request Mail')
                    ->with([ 'data' => $this->data ]);
    }
}
