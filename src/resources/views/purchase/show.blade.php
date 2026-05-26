@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="purchase-container">

    <div class="purchase-left">

        <div class="purchase-item">
            <div class="purchase-image">
                @if ($item->image)
                    <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}"
                         alt="商品画像"
                         class="purchase-image__img">
                @else
                    商品画像
                @endif
            </div>

            <div>
                <h2>{{ $item->name }}</h2>
                <p>{{ number_format($item->price) }}</p>
            </div>
        </div>

        <form id="purchase-form" action="/purchase/{{ $item->id }}" method="POST">
            @csrf

            <div class="purchase-section">
                <h3>支払い方法</h3>

                <input type="hidden" name="payment_method" id="payment_method">

                <div class="custom-select" id="customSelect">
                    <div class="custom-select__selected">選択してください</div>

                    <div class="custom-select__options">
                        <div class="custom-select__option" data-value="コンビニ支払い">コンビニ支払い</div>
                        <div class="custom-select__option" data-value="カード支払い">カード支払い</div>
                    </div>
                </div>

                @error('payment_method')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="purchase-section">
                <div class="purchase-address-title">
                    <h3>配送先</h3>
                    <a href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>

                <p>〒{{ auth()->user()->postal_code }}</p>
                <p>{{ auth()->user()->address }}</p>
                <p>{{ auth()->user()->building }}</p>
            </div>
        </form>

    </div>

    <div class="purchase-right">
        <div class="summary-row">
            <span>商品代金</span>
            <span>¥{{ number_format($item->price) }}</span>
        </div>

        <div class="summary-row">
            <span>支払方法</span>
            <span id="selected-payment">選択してください</span>
        </div>

        <button type="submit" form="purchase-form" class="purchase-submit">
            購入する
        </button>
    </div>

</div>

<script>
const customSelect = document.getElementById('customSelect');
const selected = customSelect.querySelector('.custom-select__selected');
const options = customSelect.querySelector('.custom-select__options');
const optionItems = customSelect.querySelectorAll('.custom-select__option');
const hiddenInput = document.getElementById('payment_method');
const selectedPayment = document.getElementById('selected-payment');

selected.addEventListener('click', function () {
    options.style.display = options.style.display === 'block' ? 'none' : 'block';
});

optionItems.forEach(function (option) {
    option.addEventListener('click', function () {
        const value = this.dataset.value;

        selected.textContent = value;
        hiddenInput.value = value;
        selectedPayment.textContent = value;

        optionItems.forEach(item => item.classList.remove('is-selected'));
        this.classList.add('is-selected');

        options.style.display = 'none';
    });
});
</script>
@endsection