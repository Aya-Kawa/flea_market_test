<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_「購入する」ボタンを押下すると購入が完了する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);


        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

    }



    public function test_購入した商品は商品一覧画面にて「sold」と表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'name' => '購入済み商品'
        ]);

        $purchase = Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');
        $response->assertSee('SOLD');
    }


    public function test_プロフィール購入した商品一覧に追加されている()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'name' => '購入済み商品'
        ]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage?tab=buy');
        $response->assertSee('購入済み商品');
    }




}
