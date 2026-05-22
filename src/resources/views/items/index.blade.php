@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
    <div class="item-tabs">
        <a href="/?keyword={{ request('keyword') }}"
   class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">
    おすすめ
</a>

<a href="/?tab=mylist&keyword={{ request('keyword') }}"
   class="{{ request('tab') === 'mylist' ? 'active' : '' }}">
    マイリスト
</a>
    </div>

    <div class="item-list">

        @foreach ($items as $item)
            <a href="/item/{{ $item->id }}" class="item-card">

                <div class="item-image">
    @if ($item->image)

    @if (Str::startsWith($item->image, 'http'))
        <img src="{{ $item->image }}" class="detail-image">
    @else
        <img src="{{ asset('storage/' . $item->image) }}" class="detail-image">
    @endif

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
