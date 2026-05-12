@extends('layouts.app')

@section('content')
    <div class="auth-container">
        <h2 class="auth-title">会員登録</h2>

        <form method="POST" action="/register" novalidate>
            @csrf

            <div class="auth-group">
                <label>ユーザー名</label>
                <input type="text" name="name" class="auth-input">
                @error('name')
    <p class="error-message">{{ $message }}</p>
@enderror
            </div>

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

            <div class="auth-group">
                <label>確認用パスワード</label>
                <input type="password" name="password_confirmation" class="auth-input">
            </div>

            <button type="submit" class="auth-button">登録する</button>

            <p class="auth-link">
                <a href="/login">ログインはこちら</a>
            </p>
        </form>
    </div>
@endsection
