@extends('layouts.app')

@section('content')
    <div class="item-tabs">
        <a href="/" class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">
            おすすめ
        </a>

        <a href="/?tab=mylist" class="{{ request('tab') === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
    </div>

    <div class="item-list">

        @foreach ($items as $item)
            <a href="/item/{{ $item->id }}" class="item-card">

                <div class="item-image">
    @if ($item->image)
        <img src="{{ asset('storage/' . $item->image) }}" class="item-card-img">
    @else
        商品画像
    @endif

    @if ($item->purchase)
        <span class="sold-label">Sold</span>
    @endif
</div>

                <p class="item-name">
                    {{ $item->name }}
                </p>

            </a>
        @endforeach

    </div>
@endsection
