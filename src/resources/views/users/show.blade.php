@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
    <div class="mypage">

        <div class="mypage-header">
            <div class="mypage-icon">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" class="mypage-profile-image">
                @endif
            </div>
            <h2>{{ $user->name }}</h2>

            <a href="/mypage/profile">
                プロフィールを編集
            </a>
        </div>

        <div class="mypage-tabs">
            <a href="/mypage?page=sell">出品した商品</a>
            <a href="/mypage?page=buy">購入した商品</a>
        </div>

        <div class="item-list">

            @foreach ($items as $item)
    <a href="/item/{{ $item->id }}" class="item-card">
        <div class="item-card__image">
            @if ($item->image)
    @if (Str::startsWith($item->image, 'http'))
        <img src="{{ $item->image }}" class="item-card__img">
    @else
        <img src="{{ asset('storage/' . $item->image) }}" class="item-card__img">
    @endif
@else
    商品画像
@endif
        </div>

        <p class="item-name">{{ $item->name }}</p>
    </a>
@endforeach

        </div>

    </div>
@endsection
