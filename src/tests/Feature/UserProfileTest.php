<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_information_is_displayed()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profiles/test.jpg',
            'email_verified_at' => now(),
        ]);

        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品した商品',
        ]);

        $buyItem = Item::factory()->create([
            'name' => '購入した商品',
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
            'payment_method' => 'コンビニ支払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('出品した商品');

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入した商品');
    }
    public function test_user_profile_can_be_updated()
{
    $user = User::factory()->create([
        'name' => '変更前',
        'postal_code' => '111-1111',
        'address' => '変更前住所',
        'building' => '変更前建物',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)->post('/mypage/profile', [
        'name' => '変更後ユーザー',
        'postal_code' => '222-2222',
        'address' => '変更後住所',
        'building' => '変更後建物',
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => '変更後ユーザー',
        'postal_code' => '222-2222',
        'address' => '変更後住所',
        'building' => '変更後建物',
    ]);
}
public function test_name_is_required_when_updating_profile()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->post('/mypage/profile', [
        'name' => '',
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
    ]);

    $response->assertSessionHasErrors([
        'name' => 'ユーザー名を入力してください',
    ]);
}
public function test_name_must_be_20_characters_or_less()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->post('/mypage/profile', [
        'name' => str_repeat('あ', 21),
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
    ]);

    $response->assertSessionHasErrors([
        'name' => 'ユーザー名は20文字以内で入力してください',
    ]);
}
public function test_postal_code_is_required()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->post('/mypage/profile', [
        'name' => 'テストユーザー',
        'postal_code' => '',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
    ]);

    $response->assertSessionHasErrors([
        'postal_code' => '郵便番号を入力してください',
    ]);
}
public function test_postal_code_must_include_hyphen()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->post('/mypage/profile', [
        'name' => 'テストユーザー',
        'postal_code' => '1234567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
    ]);

    $response->assertSessionHasErrors([
        'postal_code' => '郵便番号はハイフンありで入力してください',
    ]);
}
public function test_address_is_required()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->post('/mypage/profile', [
        'name' => 'テストユーザー',
        'postal_code' => '123-4567',
        'address' => '',
        'building' => 'テストビル101',
    ]);

    $response->assertSessionHasErrors([
        'address' => '住所を入力してください',
    ]);
}
public function test_profile_image_must_be_jpeg_or_png()
{
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $file = UploadedFile::fake()->create(
        'sample.pdf',
        100,
        'application/pdf'
    );

    $response = $this->actingAs($user)->post('/mypage/profile', [
        'name' => 'テストユーザー',
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
        'profile_image' => $file,
    ]);

    $response->assertSessionHasErrors([
        'profile_image' => '画像はjpegまたはpng形式でアップロードしてください',
    ]);
}

}