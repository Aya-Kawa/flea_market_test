<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;


class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みのユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comments', [
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
        $response->assertRedirect();
    }

    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post('/item/' . $item->id . '/comments', [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_コメントが入力されていない場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comments', [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_コメントが255字以上の場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comments', [
            'content' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('content');
    }

}



