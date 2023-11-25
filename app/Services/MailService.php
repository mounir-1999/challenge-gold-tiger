<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Models\EmailLog;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailService
{
    function sendWelcomeMail($id)
    {
        $user = User::findOrFail($id);
        // create log entry
        EmailLog::create([
            'user_id' => $user->id,
            'email_type' => 'welcome_email'
        ]);
        // Mail will be send to queue, then processed
        Mail::to($user)->queue(new WelcomeMail($user));
    }
}
