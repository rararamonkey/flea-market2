@extends('layouts.app')

@section('content')
    <div class="mypage">

        <div class="mypage-header">
            <div class="mypage-icon">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}">
                @else
                    <div class="mypage-icon"></div>
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
                <div class="item-card">

                    <div class="item-image">
                        商品画像
                    </div>

                    <p>{{ $item->name }}</p>

                </div>
            @endforeach

        </div>

    </div>
@endsection
