<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Like;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items_are_displayed()
    {
        Item::factory()->create([
            'name' => '商品A'
        ]);

        Item::factory()->create([
            'name' => '商品B'
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
    }

    public function test_sold_label_is_displayed_for_purchased_item()
{
    $item = Item::factory()->create([
        'name' => '購入済み商品',
    ]);

    Purchase::factory()->create([
        'item_id' => $item->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('購入済み商品');
    $response->assertSee('Sold');
}

public function test_items_created_by_login_user_are_not_displayed()
{
    $user = User::factory()->create();

    Item::factory()->create([
        'user_id' => $user->id,
        'name' => '自分の商品',
    ]);

    Item::factory()->create([
        'name' => '他人の商品',
    ]);

    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200);
    $response->assertDontSee('自分の商品');
    $response->assertSee('他人の商品');
}
public function test_only_liked_items_are_displayed_in_mylist()
{
    $user = User::factory()->create();

    $likedItem = Item::factory()->create([
        'name' => 'いいねした商品',
    ]);

    $notLikedItem = Item::factory()->create([
        'name' => 'いいねしていない商品',
    ]);

    Like::factory()->create([
        'user_id' => $user->id,
        'item_id' => $likedItem->id,
    ]);

    $response = $this->actingAs($user)
        ->get('/?tab=mylist');

    $response->assertStatus(200);
    $response->assertSee('いいねした商品');
    $response->assertDontSee('いいねしていない商品');
}
public function test_sold_label_is_displayed_in_mylist_for_purchased_item()
{
    $user = User::factory()->create();

    $item = Item::factory()->create([
        'name' => 'マイリスト購入済み商品',
    ]);

    Like::factory()->create([
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);

    Purchase::factory()->create([
        'item_id' => $item->id,
    ]);

    $response = $this->actingAs($user)
        ->get('/?tab=mylist');

    $response->assertStatus(200);
    $response->assertSee('マイリスト購入済み商品');
    $response->assertSee('Sold');
}

public function test_mylist_is_empty_when_user_is_not_authenticated()
{
    Item::factory()->create([
        'name' => '未ログインでは見えない商品',
    ]);

    $response = $this->get('/?tab=mylist');

    $response->assertStatus(200);
    $response->assertDontSee('未ログインでは見えない商品');
}
public function test_items_can_be_searched_by_partial_name()
{
    Item::factory()->create([
        'name' => 'Apple Watch',
    ]);

    Item::factory()->create([
        'name' => 'iPhone',
    ]);

    $response = $this->get('/?keyword=Apple');

    $response->assertStatus(200);
    $response->assertSee('Apple Watch');
    $response->assertDontSee('iPhone');
}
public function test_search_keyword_is_kept_in_mylist()
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/?tab=mylist&keyword=Apple');

    $response->assertStatus(200);

    $response->assertSee('keyword=Apple', false);
}
}