<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_notice_screen_is_displayed()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('登録していただいたメールアドレスに認証メールを送付しました。');
        $response->assertSee('メール認証を完了してください。');
        $response->assertSee('認証はこちらから');
        $response->assertSee('http://localhost:8025', false);
        $response->assertSee('認証メールを再送する');
    }
    public function test_verification_email_can_be_resent()
{
    Notification::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($user)
        ->post('/email/verification-notification');

    $response->assertStatus(302);

    Notification::assertSentTo(
        $user,
        VerifyEmail::class
    );
}
public function test_user_is_redirected_to_profile_after_email_verification()
{
    Event::fake();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);

    $this->assertTrue($user->fresh()->hasVerifiedEmail());

    $response->assertRedirect('/mypage/profile');
}
}