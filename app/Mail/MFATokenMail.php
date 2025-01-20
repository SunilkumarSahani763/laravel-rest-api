<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MFATokenMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mfaToken;

    public function __construct($mfaToken)
    {
        $this->mfaToken = $mfaToken;
    }

    public function build()
    {
        return $this->subject('Your MFA Token')->view('emails.mfa_token');
    }
}
