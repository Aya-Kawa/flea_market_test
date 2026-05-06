<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;

class SearchTest extends TestCase
{

    use RefreshDatabase;

    public function test_「商品名」で部分一致検索ができる()
    {
        Item::factory()->create(['name' => '腕時計']);
        Item::factory()->create(['name' => 'バッグ']);

        $response = $this->get('/?keyword=時');

        $response->assertSee('腕時計');
        $response->assertDontSee('バッグ');
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create(['name' => '腕時計']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=時');

        $response->assertSee('腕時計');
    }

}
