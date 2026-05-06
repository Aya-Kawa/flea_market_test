<?php

namespace Tests\Feature;

use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{

    use RefreshDatabase;

    public function test_必要な情報が表示される（商品画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、商品情報（カテゴリ、商品の状態）、コメント数、コメントしたユーザー情報、コメント内容）()
    {
        $user = User::factory()->create(['name' => 'テストユーザー']);

        $condition = Condition::factory()->create(['name' => '良好']);

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 1000,
            'description' => 'テスト商品説明',
            'condition_id' => $condition->id,
            'image_path' => 'items/test.jpg',
        ]);

        $category1 = Category::factory()->create(['name' => 'レディース']);
        $category2 = Category::factory()->create(['name' => 'トップス']);

        $item->categories()->attach([$category1->id, $category2->id]);

        Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('1,000');
        $response->assertSee('テスト商品説明');
        $response->assertSee('レディース');
        $response->assertSee('トップス');
        $response->assertSee('良好');
        $response->assertSee('items/test.jpg');
        $response->assertSee('テストユーザー');
        $response->assertSee('テストコメント');
    }

    public function test_複数選択されたカテゴリが表示されているか()
    {
        $item = Item::factory()->create();

        $category1 = Category::factory()->create(['name' => 'ファッション']);
        $category2 = Category::factory()->create(['name' => 'メンズ']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }


}
