@extends('layouts.app')

@section('content')
    <div class="profile-container">

        <h2 class="profile-title">プロフィール設定</h2>

        <form action="/mypage/profile" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-image-area">
                <div class="profile-icon">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : '' }}"
                        class="profile-image-preview" id="profile_preview">
                </div>
                <label class="image-select-button">
                    画像を選択する
                    <input type="file" name="profile_image" id="profile_image" hidden>
                    @error('profile_image')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <div class="profile-group">
                <label>ユーザー名</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="profile-input">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-group">
                <label>郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}"
                    class="profile-input">
                @error('postal_code')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-group">
                <label>住所</label>
                <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}"
                    class="profile-input">
                @error('address')
                    <p class="error-message">{{ $message }}</p>
                @enderror
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
    <script>
        const imageInput = document.getElementById('profile_image');
        const preview = document.getElementById('profile_preview');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
