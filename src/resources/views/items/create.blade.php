@extends('layouts.app')

@section('content')
<div class="sell-container">

    <h2 class="sell-title">商品の出品</h2>

    <form action="/sell" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sell-group">
            <label>商品画像</label>
            <input type="file" name="image">
            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <h3 class="sell-section-title">商品の詳細</h3>

        <div class="sell-group">
            <label>カテゴリー</label>

            <div class="sell-category-list">
                @foreach ($categories as $category)
                    <label class="sell-category">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>

            @error('categories')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-group">
            <label>商品の状態</label>
            <select name="condition" class="sell-input sell-select">
    <option value="">選択してください</option>
    <option value="良好" {{ old('condition') === '良好' ? 'selected' : '' }}>良好</option>
    <option value="目立った傷や汚れなし" {{ old('condition') === '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
    <option value="やや傷や汚れあり" {{ old('condition') === 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
    <option value="状態が悪い" {{ old('condition') === '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
</select>
            @error('condition')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <h3 class="sell-section-title">商品名と説明</h3>

        <div class="sell-group">
            <label>商品名</label>
            <input type="text" name="name" class="sell-input" value="{{ old('name') }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-group">
            <label>ブランド名</label>
            <input type="text" name="brand" class="sell-input" value="{{ old('brand') }}">
        </div>

        <div class="sell-group">
            <label>商品の説明</label>
            <textarea name="description" class="sell-textarea">{{ old('description') }}</textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-group">
            <label>販売価格</label>
            <div class="price-input-area">
    <span class="price-yen">¥</span>

    <input
        type="text"
        name="price"
        class="sell-input price-input"
        value="{{ old('price') }}"
    >
</div>
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="sell-submit">
            出品する
        </button>

    </form>

</div>
@endsection