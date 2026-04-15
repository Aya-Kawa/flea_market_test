@extends('layouts.app')

@section('content')
<div>//外枠
    <div>
        <h2>住所の変更</h2>

        <form action="{{ route('purchase.updateAddress', ['item' => $item->id]) }}" method="POST">
            @csrf
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code"
                value="{{ old('postal_code', $purchaseAddress['postal_code'] ?? '') }}">
            @foreach ($errors->get('postal_code') as $error)
                <p>{{ $error }}</p>
            @endforeach
            <label for="address">住所</label>
            <input type="text" name="address" value="{{ old('address', $purchaseAddress['address'] ?? '') }}" />
            @foreach ($errors->get('address') as $error)
                <p>{{ $error }}</p>
            @endforeach
            <label for="building">建物名</label>
            <input type="text" name="building" value="{{ old('building', $purchaseAddress['building'] ?? '') }}" />
            @foreach ($errors->get('building') as $error)
                <p>{{ $error }}</p>
            @endforeach
            <button type="submit">変更する</button>
        </form>
    </div>












</div>//外枠