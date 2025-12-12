<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ip;
    public $time;

    public function __construct($user)
    {
        $this->user = $user;
        $this->ip = request()->ip();
        $this->time = now()->toDateTimeString();
    }

    public function build()
    {
        return $this->subject('Thông báo đăng nhập tài khoản')
            ->view('emails.login_notification')->view('emails.login');
    }
}
