<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertSee('テストユーザー');
        $response->assertSee('profiles/test.jpg');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル101');
    }
}
