<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;
    public function test_商品出品画面にて必要な情報が保存できる()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'name' => 'ファッション',
        ]);
        $condition = Condition::factory()->create([
            'name' => '良好',
        ]);
        $response = $this->actingAs($user)->post(route('sell.store'), [
            'image' => UploadedFile::fake()->create('item.jpg'),
            'categories' => [$category->id],
            'condition_id' => $condition->id,
            'name' => '革靴',
            'brand_name' => 'ブランドA',
            'description' => '商品の説明です',
            'price' => 4000,
        ]);
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => '革靴',
            'brand_name' => 'ブランドA',
            'description' => '商品の説明です',
            'price' => 4000,
        ]);
        $item = Item::where('name', '革靴')->first();
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
        $response->assertRedirect();
    }
}
