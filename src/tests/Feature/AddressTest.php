<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('purchase.updateAddress', ['item' => $item->id]), [
                'postal_code' => '123-4567',
                'address' => '東京都新宿区西新宿2-8-1',
                'building' => '新宿モノリスビル',
            ]);

        $response = $this->get(route('purchase.create', ['item' => $item->id]));
        $response = $this->actingAs($user)->get(route('purchase.create', ['item' => $item->id]));

        $response->assertSee('123-4567');
        $response->assertSee('東京都新宿区西新宿2-8-1');
        $response->assertSee('新宿モノリスビル');
    }

    public function test_購入した商品に送付先住所が紐づいて登録される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都新宿区西新宿2-8-1',
            'building' => '新宿モノリスビル',
        ]);
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都新宿区西新宿2-8-1',
            'building' => '新宿モノリスビル',
        ]);
    }

}
