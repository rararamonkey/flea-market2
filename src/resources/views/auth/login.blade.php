@extends('layouts.app')

@section('content')
    <div class="auth-container">
        <h2 class="auth-title">ログイン</h2>

        <form method="POST" action="/login" novalidate>
            @csrf

            <div class="auth-group">
                <label>メールアドレス</label>
                <input type="email" name="email" class="auth-input">
                @error('email')
    <p class="error-message">{{ $message }}</p>
@enderror
            </div>

            <div class="auth-group">
                <label>パスワード</label>
                <input type="password" name="password" class="auth-input">
                @error('password')
    <p class="error-message">{{ $message }}</p>
@enderror
            </div>

            @if (session('error'))
                <p style="color:red; text-align:center;">
                    {{ session('error') }}
                </p>
            @endif
            <button type="submit" class="auth-button">ログインする</button>

            <p class="auth-link">
                <a href="/register">会員登録はこちら</a>

        </form>
    </div>
@endsection
