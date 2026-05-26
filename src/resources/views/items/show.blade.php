@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
    <div class="item-detail">

    <div class="item-detail__image">
   @if ($item->image)

    @if (Str::startsWith($item->image, 'http'))
        <img src="{{ $item->image }}" class="item-card-img">
    @else
        <img src="{{ asset('storage/' . $item->image) }}" class="item-card-img">
    @endif

@else
    商品画像
@endif
</div>

    <div class="item-detail__content">
        <h2>{{ $item->name }}</h2>
            <p class="item-detail__brand">
                {{ $item->brand }}
            </p>

            <p class="item-detail__price">
                ¥{{ number_format($item->price) }} <span>（税込）</span>
            </p>

            <div class="item-icons">

    @if (!(Auth::check() && Auth::id() === $item->user_id))
        <div class="icon-group">
            {{-- いいね --}}
            @php
                $isLiked = auth()->check() && $item->likes->where('user_id', auth()->id())->isNotEmpty();
            @endphp

            @auth
                @if ($isLiked)
                    <form action="/like" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="like-button">
                            <img src="{{ asset('images/heart-pink.png') }}" class="icon-image">
                        </button>
                    </form>
                @else
                    <form action="/like" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="like-button">
                            <img src="{{ asset('images/heart-default.png') }}" class="icon-image">
                        </button>
                    </form>
                @endif
            @endauth

            <p>{{ $item->likes->count() }}</p>
        </div>
    @endif

    <div class="icon-group">
        <img src="{{ asset('images/icon.png') }}" class="icon-image">
        <p>{{ $item->comments->count() }}</p>
    </div>

</div>

            @if ($item->purchase)
    <button class="sold-button" disabled>
        Sold
    </button>
@elseif (Auth::check() && Auth::id() === $item->user_id)
    {{-- 自分の商品なので購入ボタンは表示しない --}}
@else
    <a href="/purchase/{{ $item->id }}" class="purchase-button">
        購入手続きへ
    </a>
@endif

            <h3>商品説明</h3>
            <p>{{ $item->description }}</p>

            <h3>商品の情報</h3>

            <div class="item-info-row">
                <strong>カテゴリー</strong>

                @foreach ($item->categories as $category)
                    <span class="category-tag">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>

            <div class="item-info-row">
                <span class="item-info-label">商品の状態</span>
                <span>{{ $item->condition }}</span>
            </div>

            <h3>コメント({{ $item->comments->count() }})</h3>

            @foreach ($item->comments as $comment)
                <div class="comment-box">
                    <div class="comment-user">
                        <div class="comment-icon">
                            @if ($comment->user->profile_image)
                                <img src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                    class="comment-profile-image">
                            @endif
                        </div>

                        <strong>{{ $comment->user->name }}</strong>

                        <p class="comment-content">
                            {{ $comment->content }}
                        </p>
                    </div>
            @endforeach

            @auth
                <form action="/comment" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                    <label class="comment-label">
                        商品へのコメント
                    </label>

                    <textarea name="content" class="comment-textarea"></textarea>

                    @error('content')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror

                    <button type="submit" class="comment-button">
                        コメントを送信する
                    </button>
                </form>
            @endauth

        </div>
    </div>
@endsection
