<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailService
{
    function sendWelcomeMail($id)
    {
        $user = User::findOrFail($id);
        // Mail will be send to queue, then processed
        Mail::to($user)->queue(new WelcomeMail($user));
    }
}
