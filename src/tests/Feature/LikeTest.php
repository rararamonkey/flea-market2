<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_item()
{
    $user = User::factory()->create();

    $item = Item::factory()->create();

    $this->actingAs($user)
        ->post('/like', [
            'item_id' => $item->id,
        ]);

    $this->assertDatabaseHas('likes', [
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);
    $this->assertEquals(
    1,
    Like::where('item_id', $item->id)->count()
);
}

public function test_user_can_unlike_item()
{
    $user = User::factory()->create();

    $item = Item::factory()->create();

    Like::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);

    $this->actingAs($user)
        ->delete('/like', [
            'item_id' => $item->id,
        ]);

    $this->assertDatabaseMissing('likes', [
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);
}
}