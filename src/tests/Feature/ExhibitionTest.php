<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_exhibit_item()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $category = Category::create([
            'name' => '家電',
        ]);

        $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');
        $this->actingAs($user)->post('/sell', [
            'name' => '出品テスト商品',
            'brand' => 'Apple',
            'description' => 'テスト説明',
            'price' => 10000,
            'condition' => '良好',
            'categories' => [$category->id],
            'image' => $image,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => '出品テスト商品',
            'brand' => 'Apple',
            'price' => 10000,
            'description' => 'テスト説明',
            'condition' => '良好',
            'user_id' => $user->id,
        ]);

        $item = Item::where('name', '出品テスト商品')->first();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
    }
}