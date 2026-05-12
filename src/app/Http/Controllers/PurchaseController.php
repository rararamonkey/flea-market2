<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);

        return view('purchase.show', compact('item'));
    }

    public function store(Request $request, $item_id)
{
    Purchase::create([
        'user_id' => auth()->id(),
        'item_id' => $item_id,
        'payment_method' => $request->payment_method,
    ]);

    return redirect('/');
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