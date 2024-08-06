<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var
     */
    public $data;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->data = $request;
    }

    /**
     * Build the message.
     *
     * @param $request
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), getSettings('general','brand_name'))
            ->subject('Cappadociavisitor Password Reset.')
            ->view('mail.forgot-password')->with([
                'data' => $this->data
            ]);
    }
}
