<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_item()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'カード払い',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response->assertRedirect('/');
    }
    public function test_purchased_item_is_displayed_as_sold()
{
    $user = User::factory()->create([
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
    ]);

    $item = Item::factory()->create([
        'name' => '購入済み商品',
    ]);

    Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'payment_method' => 'コンビニ支払い',
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('購入済み商品');
    $response->assertSee('Sold');
}
public function test_shipping_address_can_be_updated_and_displayed_on_purchase_page()
{
    $user = User::factory()->create([
        'postal_code' => '111-1111',
        'address' => '変更前住所',
        'building' => '変更前建物',
        'email_verified_at' => now(),
    ]);

    $item = Item::factory()->create();

    $this->actingAs($user)->post('/purchase/address/' . $item->id, [
        'postal_code' => '222-2222',
        'address' => '変更後住所',
        'building' => '変更後建物',
    ]);

    $response = $this->actingAs($user)->get('/purchase/' . $item->id);

    $response->assertStatus(200);
    $response->assertSee('222-2222');
    $response->assertSee('変更後住所');
    $response->assertSee('変更後建物');
}
public function test_changed_address_is_saved_when_item_is_purchased()
{
    $user = User::factory()->create([
        'postal_code' => '111-1111',
        'address' => '変更前住所',
        'building' => '変更前建物',
        'email_verified_at' => now(),
    ]);

    $item = Item::factory()->create();

    $this->actingAs($user)->post('/purchase/address/' . $item->id, [
        'postal_code' => '222-2222',
        'address' => '変更後住所',
        'building' => '変更後建物',
    ]);

    Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'payment_method' => 'コンビニ支払い',
        'postal_code' => '222-2222',
        'address' => '変更後住所',
        'building' => '変更後建物',
    ]);

    $this->assertDatabaseHas('purchases', [
        'item_id' => $item->id,
        'postal_code' => '222-2222',
        'address' => '変更後住所',
        'building' => '変更後建物',
    ]);
}
public function test_purchased_item_is_displayed_as_sold_in_item_list()
{
    $user = User::factory()->create();

    $item = Item::factory()->create([
        'name' => '購入済み商品',
    ]);

    Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'payment_method' => 'コンビニ支払い',
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('購入済み商品');
    $response->assertSee('Sold');
}
public function test_payment_method_options_are_displayed_on_purchase_page()
{
    $user = User::factory()->create([
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
        'email_verified_at' => now(),
    ]);

    $item = Item::factory()->create([
        'name' => 'テスト商品',
        'price' => 10000,
    ]);

    $response = $this->actingAs($user)->get('/purchase/' . $item->id);

    $response->assertStatus(200);
    $response->assertSee('支払い方法');
    $response->assertSee('コンビニ支払い');
    $response->assertSee('カード支払い');
    $response->assertSee('支払方法');
    $response->assertSee('選択してください');
    $response->assertSee('id="selected-payment"', false);
    $response->assertSee('id="payment_method"', false);
}
public function test_payment_method_is_required_when_purchasing()
{
    $user = User::factory()->create([
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区',
        'building' => 'テストビル101',
        'email_verified_at' => now(),
    ]);

    $item = Item::factory()->create();

    $response = $this->actingAs($user)->post('/purchase/' . $item->id, [
        'payment_method' => '',
    ]);

    $response->assertSessionHasErrors([
        'payment_method' => '支払い方法を選択してください',
    ]);
}
}