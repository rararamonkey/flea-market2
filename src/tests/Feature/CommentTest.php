<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_user_can_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/comment', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_guest_user_cannot_comment()
    {
        $item = Item::factory()->create();

        $this->post('/comment', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/comment', [
            'item_id' => $item->id,
            'content' => '',
        ]);

        $response->assertSessionHasErrors([
            'content' => 'コメントを入力してください',
        ]);
    }

    public function test_comment_must_be_255_characters_or_less()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/comment', [
            'item_id' => $item->id,
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors([
            'content' => '255文字以内で入力してください',
        ]);
    }
}