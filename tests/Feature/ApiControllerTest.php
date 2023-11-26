<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Mail\WelcomeMail;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_send_welcome_email_route_exists(): void
    {
        $user = User::factory()->create();
        $response = $this->post("api/users/$user->id/welcome");
        $this->assertTrue($response->status() != 404);
    }

    /**
     * A basic test example.
     */
    public function test_send_welcome_email_route_sends_email_to_queue(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $response = $this->post("api/users/$user->id/welcome");
        Mail::assertQueued(WelcomeMail::class);
    }
}
