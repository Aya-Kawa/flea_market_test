<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use App\Models\Purchase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねした商品だけが表示される()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create(['name' => 'いいねした商品']);
        $unlikedItem = Item::factory()->create(['name' => 'いいねしていない商品']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    public function test_購入済み商品は「Sold」と表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => '購入済みいいね商品']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);


        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee('SOLD');
    }

    public function test_未認証の場合は何も表示されない()
    {
        Item::factory()->create(['name' => 'いいねした商品']);

        $response = $this->get('/?tab=mylist');
        $response->assertDontSee('いいねした商品');
    }

}
