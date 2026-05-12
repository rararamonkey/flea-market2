@extends('layouts.app')

@section('content')
    <div class="purchase-container">

        <div class="purchase-left">

            <div class="purchase-item">
                <div class="purchase-image">
                    商品画像
                </div>

                <div>
                    <h2>{{ $item->name }}</h2>
                    <p>{{ number_format($item->price) }}</p>
                </div>
            </div>

            <form action="/purchase/{{ $item->id }}" method="POST">
                @csrf

                <div class="purchase-section">
                    <h3>支払い方法</h3>

                    <select name="payment_method" class="purchase-select">
                        <option value="">選択してください</option>
                        <option value="コンビニ支払い">コンビニ支払い</option>
                        <option value="カード支払い">カード支払い</option>
                    </select>
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

                <button type="submit" class="purchase-submit">
                    購入する
                </button>
            </form>

        </div>

        <div class="purchase-right">
            <div class="summary-row">
                <span>商品代金</span>
                <span>¥{{ number_format($item->price) }}</span>
            </div>

            <div class="summary-row">
                <span>支払方法</span>
                <span>選択してください</span>
            </div>

        </div>
    @endsection
