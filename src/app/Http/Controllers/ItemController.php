<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    // 一覧表示
    public function index(Request $request)
{
    $keyword = $request->keyword;
    $tab = $request->tab;

    $items = Item::query();

    // 商品名で検索
    if (!empty($keyword)) {
        $items->where('name', 'like', '%' . $keyword . '%');
    }

    // マイリスト
    if ($tab === 'mylist') {
        if (Auth::check()) {
            $items->whereHas('likes', function ($query) {
                $query->where('user_id', Auth::id());
            });
        } else {
            $items->whereRaw('1 = 0');
        }
    } else {
        // おすすめ：自分が出品した商品は非表示
        if (Auth::check()) {
            $items->where('user_id', '!=', Auth::id());
        }
    }

    $items = $items->get();

    return view('items.index', compact('items', 'keyword', 'tab'));
}


    // 詳細表示
    public function show($item_id)
{
    $item = Item::with(['likes', 'comments.user'])->findOrFail($item_id);

    return view('items.show', compact('item'));
}

    // 出品画面
    public function create()
{
    $categories = Category::all();

    return view('items.create', compact('categories'));
}

    // 保存（ここでRequest使う）
    public function store(ExhibitionRequest $request)
{
    $imagePath = $request->file('image')->store('items', 'public');

    $item = Item::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'brand' => $request->brand,
        'price' => $request->price,
        'description' => $request->description,
        'condition' => $request->condition,
        'image' => $imagePath,
    ]);

    $item->categories()->attach($request->categories);

    return redirect('/');
}
}