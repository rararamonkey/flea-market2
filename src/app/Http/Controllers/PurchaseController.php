<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show($item_id)
{
    $item = Item::findOrFail($item_id);

    if (Purchase::where('item_id', $item->id)->exists()) {
        return redirect('/');
    }

    return view('purchase.show', compact('item'));
}

    public function store(PurchaseRequest $request, $item_id)
{
    $item = Item::findOrFail($item_id);
    $user = auth()->user();

    if (empty($user->postal_code) || empty($user->address)) {
    return redirect('/mypage/profile');
}

    if (Purchase::where('item_id', $item->id)->exists()) {
        return redirect('/')->with('error', 'この商品はすでに購入されています');
    }

    Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'payment_method' => $request->payment_method,
        'postal_code' => $user->postal_code,
        'address' => $user->address,
        'building' => $user->building,
    ]);

    $paymentTypes = ['card'];

    if ($request->payment_method === 'コンビニ支払い') {
        $paymentTypes = ['konbini'];
    }

    Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::create([
        'payment_method_types' => $paymentTypes,
        'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $item->name,
                ],
                'unit_amount' => $item->price,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => url('/'),
        'cancel_url' => url('/purchase/' . $item->id),
    ]);

    return redirect($session->url);
}
    public function address($item_id)
{
    $item = Item::findOrFail($item_id);

    return view('purchase.address', compact('item'));
}
public function updateAddress(Request $request, $item_id)
{
    auth()->user()->update([
        'postal_code' => $request->postal_code,
        'address' => $request->address,
        'building' => $request->building,
    ]);

    return redirect('/purchase/' . $item_id);
}
}