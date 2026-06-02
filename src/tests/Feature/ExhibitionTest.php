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
    public function test_item_name_is_required_when_exhibiting()
{
    Storage::fake('public');

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $category = Category::create([
        'name' => '家電',
    ]);

    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => '',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => 10000,
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'name' => '商品名を入力してください',
    ]);
}
public function test_item_description_is_required_when_exhibiting()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $category = Category::create([
        'name' => '家電',
    ]);

    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => '',
        'price' => 10000,
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'description' => '商品説明を入力してください',
    ]);
}
public function test_item_image_is_required_when_exhibiting()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $category = Category::create([
        'name' => '家電',
    ]);

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => 10000,
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => null,
    ]);

    $response->assertSessionHasErrors([
        'image' => '商品画像を選択してください',
    ]);
}
public function test_category_is_required_when_exhibiting()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => 10000,
        'condition' => '良好',
        'categories' => [],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'categories' => 'カテゴリーを選択してください',
    ]);
}
public function test_condition_is_required_when_exhibiting()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $category = Category::create([
        'name' => '家電',
    ]);

    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => 10000,
        'condition' => '',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'condition' => '商品の状態を選択してください',
    ]);
}
public function test_price_is_required_when_exhibiting()
{
    $user = User::factory()->create(['email_verified_at' => now()]);
    $category = Category::create(['name' => '家電']);
    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => '',
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'price' => '価格を入力してください',
    ]);
}

public function test_price_must_be_integer_when_exhibiting()
{
    $user = User::factory()->create(['email_verified_at' => now()]);
    $category = Category::create(['name' => '家電']);
    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => 'abc',
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'price' => '価格は数値で入力してください',
    ]);
}

public function test_price_must_be_zero_or_more_when_exhibiting()
{
    $user = User::factory()->create(['email_verified_at' => now()]);
    $category = Category::create(['name' => '家電']);
    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => -1,
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'price' => '価格は0円以上で入力してください',
    ]);
}

public function test_description_must_be_255_characters_or_less_when_exhibiting()
{
    $user = User::factory()->create(['email_verified_at' => now()]);
    $category = Category::create(['name' => '家電']);
    $image = UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => str_repeat('あ', 256),
        'price' => 10000,
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'description' => '商品説明は255文字以内で入力してください',
    ]);
}

public function test_image_must_be_jpeg_or_png_when_exhibiting()
{
    $user = User::factory()->create(['email_verified_at' => now()]);
    $category = Category::create(['name' => '家電']);
    $image = UploadedFile::fake()->create('sample.pdf', 100, 'application/pdf');

    $response = $this->actingAs($user)->post('/sell', [
        'name' => 'テスト商品',
        'brand' => 'Apple',
        'description' => 'テスト説明',
        'price' => 10000,
        'condition' => '良好',
        'categories' => [$category->id],
        'image' => $image,
    ]);

    $response->assertSessionHasErrors([
        'image' => '商品画像はjpegまたはpng形式でアップロードしてください',
    ]);
}
}