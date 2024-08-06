<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterMail extends Mailable
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
        // Resim dosyalarını e-posta ile iliştirin
        $logoPath = public_path('assets/images/personlib_white.png');
        $mailArrowPath = public_path('assets/images/mail_arrow.png');

        return $this->from(env('MAIL_FROM_ADDRESS'), 'Personlib')
            ->subject('Demo hesabın başarıyla oluşturuldu.')
            ->view('mail.register')
            ->with([
                'data' => $this->data,
            ])
            ->attach($logoPath, [
                'as' => 'personlib_white.png',
                'mime' => 'image/png',
            ])
            ->attach($mailArrowPath, [
                'as' => 'mail_arrow.png',
                'mime' => 'image/png',
            ]);
    }
}
