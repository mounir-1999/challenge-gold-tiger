<?php

namespace App\Http\Controllers;

use App\Services\MailService;

class ApiController extends Controller
{
    protected $mailService;

    function __construct(
        MailService $mail
    ) {
        $this->mailService = $mail;
    }

    function sendWelcomeMail($id)
    {
        $this->mailService->sendWelcomeMail($id);
        return response()->json([
            'success' => 200,
            'message' => "mail request received"
        ]);
    }
}
