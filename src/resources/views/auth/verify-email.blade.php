<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<header class="verify-header">
    <img src="{{ asset('images/logo.png') }}" class="verify-logo">
</header>

<div class="verify-container">
    <p class="verify-text">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <a href="http://localhost:8025" class="verify-button" target="_blank">
        認証はこちらから
    </a>

    <form method="POST" action="/email/verification-notification">
        @csrf
        <button type="submit" class="resend-button">
            認証メールを再送する
        </button>
    </form>
</div>

</body>
</html>