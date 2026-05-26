@extends('layouts.app')

@section('content')
<div class="sell-container">

    <h2 class="sell-title">商品の出品</h2>

    <form action="/sell" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sell-group">
    <label>商品画像</label>

    <div class="image-upload-area">
    <img id="sellImagePreview" class="sell-image-preview" alt="プレビュー">

    <label class="image-upload-button" id="imageUploadButton">
        画像を選択する
        <input type="file" name="image" id="sellImageInput" accept="image/*" hidden>
    </label>
</div>

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
            <input type="hidden" name="condition" id="conditionInput" value="{{ old('condition') }}">

<div class="custom-select" id="conditionSelect">
    <div class="custom-select__selected">
        {{ old('condition') ?: '選択してください' }}
    </div>

    <div class="custom-select__options">
        <div class="custom-select__option {{ old('condition') === '良好' ? 'is-selected' : '' }}"
             data-value="良好">
            良好
        </div>

        <div class="custom-select__option {{ old('condition') === '目立った傷や汚れなし' ? 'is-selected' : '' }}"
             data-value="目立った傷や汚れなし">
            目立った傷や汚れなし
        </div>

        <div class="custom-select__option {{ old('condition') === 'やや傷や汚れあり' ? 'is-selected' : '' }}"
             data-value="やや傷や汚れあり">
            やや傷や汚れあり
        </div>

        <div class="custom-select__option {{ old('condition') === '状態が悪い' ? 'is-selected' : '' }}"
             data-value="状態が悪い">
            状態が悪い
        </div>
    </div>
</div>
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
<script>
const imageInput = document.getElementById('sellImageInput');
const imagePreview = document.getElementById('sellImagePreview');
const imageUploadButton = document.getElementById('imageUploadButton');

imageInput.addEventListener('change', function () {
    const file = this.files[0];

    if (!file) {
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        imageUploadButton.style.display = 'flex';
        return;
    }

    imagePreview.src = URL.createObjectURL(file);
    imagePreview.style.display = 'block';
    imageUploadButton.style.display = 'none';
});

const conditionSelect = document.getElementById('conditionSelect');
const conditionSelected = conditionSelect.querySelector('.custom-select__selected');
const conditionOptions = conditionSelect.querySelector('.custom-select__options');
const conditionItems = conditionSelect.querySelectorAll('.custom-select__option');
const conditionInput = document.getElementById('conditionInput');

conditionSelected.addEventListener('click', function () {

    conditionItems.forEach(function (item) {

        if (item.dataset.value === conditionInput.value) {
            item.style.display = 'none';
        } else {
            item.style.display = 'block';
        }

    });

    conditionOptions.style.display =
        conditionOptions.style.display === 'block' ? 'none' : 'block';
});

conditionItems.forEach(function (option) {

    option.addEventListener('click', function () {

        const value = this.dataset.value;

        conditionSelected.textContent = value;
        conditionInput.value = value;

        conditionItems.forEach(item => {
            item.classList.remove('is-selected');
        });

        this.classList.add('is-selected');

        conditionOptions.style.display = 'none';
    });

});
</script>
@endsection