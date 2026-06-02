<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Like;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_information_is_displayed()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'Apple',
            'price' => 10000,
            'description' => '商品説明です',
            'condition' => '良好',
        ]);

        $category = Category::create([
            'name' => '家電',
        ]);

        $item->categories()->attach($category->id);

        Comment::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'コメント内容です',
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);

        $response->assertSee('テスト商品');
        $response->assertSee('Apple');
        $response->assertSee('10,000');
        $response->assertSee('商品説明です');
        $response->assertSee('良好');
        $response->assertSee('家電');
        $response->assertSee('テストユーザー');
        $response->assertSee('コメント内容です');
    }
    public function test_multiple_categories_are_displayed()
{
    $item = Item::factory()->create();

    $category1 = Category::create([
        'name' => '家電',
    ]);

    $category2 = Category::create([
        'name' => 'ファッション',
    ]);

    $item->categories()->attach([
        $category1->id,
        $category2->id,
    ]);

    $response = $this->get('/item/' . $item->id);

    $response->assertStatus(200);

    $response->assertSee('家電');
    $response->assertSee('ファッション');
}
public function test_like_count_and_comment_count_are_displayed()
{
    $user = User::factory()->create();

    $item = Item::factory()->create();

    Like::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);

    Comment::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'content' => 'テストコメント',
    ]);

    $response = $this->get('/item/' . $item->id);

    $response->assertStatus(200);

    $response->assertSee('1');
}
public function test_comment_user_and_content_are_displayed()
{
    $user = User::factory()->create([
        'name' => 'コメントユーザー',
    ]);

    $item = Item::factory()->create();

    Comment::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'content' => 'これはテストコメントです',
    ]);

    $response = $this->get('/item/' . $item->id);

    $response->assertStatus(200);

    $response->assertSee('コメントユーザー');
    $response->assertSee('これはテストコメントです');
}
public function test_item_image_is_displayed()
{
    $item = Item::factory()->create([
        'image' => 'items/test.jpg',
    ]);

    $response = $this->get('/item/' . $item->id);

    $response->assertStatus(200);
    $response->assertSee('storage/items/test.jpg', false);
}
}