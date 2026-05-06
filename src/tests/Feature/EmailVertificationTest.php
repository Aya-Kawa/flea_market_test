<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVertificationTest extends TestCase
{

    use RefreshDatabase;

    public function test_会員登録後認証メールが送信される()
    {
        Notification::fake();
        $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $user = User::where('email', 'test@example.com')->first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }
    public function test_メール認証誘導画面で認証はこちらからボタンを押下するとメール認証サイトに遷移する()
    {
        $user = User::factory()->unverified()->create();
        $response = $this->actingAs($user)->get('/email/verify');
        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');
    }
    public function test_メール認証を完了するとプロフィール設定画面に遷移する()
    {
        $user = User::factory()->unverified()->create();
        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
        $response = $this->actingAs($user)->get($verificationUrl);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect('/mypage/profile');
    }
}

