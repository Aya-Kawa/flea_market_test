@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}"
@endsection

@section('content')
<div class="update">
    <div class="update__inner">
        <h2 class="update__title">住所の変更</h2>

        <form action="{{ route('purchase.updateAddress', ['item' => $item->id]) }}" method="POST">
            @csrf
        <div class="form__group">
            <label class="form__label "for="postal_code">郵便番号</label>
            <input class="form__input "type="text" name="postal_code"
                value="{{ old('postal_code', $purchaseAddress['postal_code'] ?? '') }}">
            @foreach ($errors->get('postal_code') as $massage)
                <p class="form__error">{{ $massage }}</p>
            @endforeach
        </div>
        
        <div class="form__group">
            <labe class="form__label for="address">住所</labe>
            <input class="form__input type="text" name="address" value="{{ old('address', $purchaseAddress['address'] ?? '') }}" />
            @foreach ($errors->get('address') as $massage)
                <p class="form__error">{{ $massage }}</p>
            @endforeach
        </div>

        <div class="form__group">
            <label class="form__label for="building">建物名</label>
            <input class="form__input type="text" name="building" value="{{ old('building', $purchaseAddress['building'] ?? '') }}" />
            @foreach ($errors->get('building') as $massage)
                <p class="form__error">{{ $massage }}</p>
            @endforeach
            <button class="form__button type="submit">変更する</button>
        </div>
        </form>
    </div>
</div>

@endsection