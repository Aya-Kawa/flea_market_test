<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profiles/test.jpg',
        ]);
        $response = $this->actingAs($user)->get(route('mypage'));
        $response->assertSee('テストユーザー');
        $response->assertSee('profiles/test.jpg');

        $user = User::factory()->create();
        $listedItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品した商品',
        ]);
        $otherItem = Item::factory()->create([
            'name' => '他人の商品',
        ]);
        $response = $this->actingAs($user)->get(route('mypage', ['page' => 'sell']));
        $response->assertSee('出品した商品');
        $response->assertDontSee('他人の商品');

        $user = User::factory()->create();
        $purchasedItem = Item::factory()->create([
            'name' => '購入した商品',
        ]);
        $notPurchasedItem = Item::factory()->create([
            'name' => '購入していない商品',
        ]);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);
        $response = $this->actingAs($user)->get(route('mypage', ['page' => 'buy']));
        $response->assertSee('購入した商品');
        $response->assertDontSee('購入していない商品');
    }
}