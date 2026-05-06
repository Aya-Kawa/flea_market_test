<?php

namespace Tests\Feature;

use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_全商品を取得できる()
    {
        $item1 = Item::factory()->create(['name' => '腕時計']);
        $item2 = Item::factory()->create(['name' => 'バック']);

        $response = $this->get('/');

        $response->assertSee('腕時計');
        $response->assertSee('バック');
    }

    public function test_購入済み商品は「Sold」と表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => '購入済み商品']);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');
        $response->assertSee('SOLD');
    }

    public function test_自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();

        Item::factory()->create(['name' => '自分の商品', 'user_id' => $user->id]);

        Item::factory()->create(['name' => '他人の商品']);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }

}
