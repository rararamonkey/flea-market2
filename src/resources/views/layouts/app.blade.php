<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
</head>

<body>

    <!-- ヘッダー -->
    <div class="header">

        <!-- ロゴ -->
        <div class="header__logo">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" class="logo">
            </a>
        </div>

        {{-- login/register 以外だけ表示 --}}
        @unless (request()->is('login') || request()->is('register'))

            <!-- 検索 -->
            <form action="/" method="GET" class="header__search">
                @if (request('tab') === 'mylist')
                    <input type="hidden" name="tab" value="mylist">
                @endif

                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
            </form>

            <!-- ナビ -->
            <div class="header__nav">

                @auth
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="header__link">
                            ログアウト
                        </button>
                    </form>

                    <a href="/mypage" class="header__link">
                        マイページ
                    </a>
                @else
                    <a href="/login" class="header__link">
                        ログイン
                    </a>
                @endauth

                <a href="/sell" class="sell-button">
                    出品
                </a>

            </div>

        @endunless

    </div>

    <!-- メイン -->
    <div class="main">
        @yield('content')
    </div>

</body>

</html>
