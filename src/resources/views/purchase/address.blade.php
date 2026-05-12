@extends('layouts.app')

@section('content')
    <div class="address-container">
        <h2 class="address-title">
            住所の変更
        </h2>

        <form action="/purchase/address/{{ $item->id }}" method="POST">
            @csrf

            <div class="address-form-group">
                <label>郵便番号</label>
                <input type="text" name="postal_code" value="{{ auth()->user()->postal_code }}" class="address-input">
            </div>

            <div class="address-form-group">
                <label>住所</label>
                <input type="text" name="address" value="{{ auth()->user()->address }}" class="address-input">
            </div>

            <div class="address-form-group">
                <label>建物名</label>
                <input type="text" name="building" value="{{ auth()->user()->building }}" class="address-input">
            </div>

            <button type="submit" class="address-button">
                更新する
            </button>
        </form>
    </div>
@endsection
