<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_小計画面で変更が反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        // ① 支払い方法変更
        $this->actingAs($user)->post(route('purchase.updatePayment', $item), [
            'payment_method' => 'カード払い',
        ]);
        // ② 購入画面表示
        $response = $this->actingAs($user)->get(route('purchase.create', $item));
        // ③ 右側に反映されているか
        $response->assertSee('カード払い');
    }


}
