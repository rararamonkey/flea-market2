@extends('layouts.app')

@section('content')
    <div class="profile-container">

        <h2 class="profile-title">プロフィール設定</h2>

        <form action="/mypage/profile" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-image-area">
                <div class="profile-icon">
                    @if (auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" class="profile-image-preview">
                    @endif
                </div>

                <label class="image-select-button">
                    画像を選択する
                    <input type="file" name="profile_image" hidden>
                </label>
            </div>

            <div class="profile-group">
                <label>ユーザー名</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="profile-input">
            </div>

            <div class="profile-group">
                <label>郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}"
                    class="profile-input">
            </div>

            <div class="profile-group">
                <label>住所</label>
                <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}"
                    class="profile-input">
            </div>

            <div class="profile-group">
                <label>建物名</label>
                <input type="text" name="building" value="{{ old('building', auth()->user()->building) }}"
                    class="profile-input">
            </div>

            <button type="submit" class="profile-button">
                更新する
            </button>
        </form>

    </div>
@endsection
