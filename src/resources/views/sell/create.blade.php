@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection
@section('content')
    <div class="sell">
        <h1 class="sell__title">商品の出品</h1>
        <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="sell__section">
                <label class="sell__label">商品画像</label>
                <div class="sell__image-area">
                    <label for="image" class="sell__image-button">画像を選択する</label>
                    <input id="image" class="sell__image-input" type="file" name="image">
                </div>
                @foreach ($errors->get('image') as $message)
                    <p class="sell__error">{{ $message }}</p>
                @endforeach
            </div>
            <div class="sell__section">
                <h2 class="sell__heading">商品の詳細</h2>
                <label class="sell__label">カテゴリー</label>
                <div class="sell__categories">
                    @foreach ($categories as $category)
                        <label class="sell__category">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @foreach ($errors->get('categories') as $message)
                    <p class="sell__error">{{ $message }}</p>
                @endforeach
                <label class="sell__label">商品の状態</label>
                <select class="sell__select" name="condition_id">
                    <option value="">選択してください</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                    @endforeach
                </select>
                @foreach ($errors->get('condition_id') as $message)
                    <p class="sell__error">{{ $message }}</p>
                @endforeach
            </div>
            <div class="sell__section">
                <h2 class="sell__heading">商品名と説明</h2>
                <label class="sell__label">商品名</label>
                <input class="sell__input" type="text" name="name" value="{{ old('name') }}">
                @foreach ($errors->get('name') as $message)
                    <p class="sell__error">{{ $message }}</p>
                @endforeach
                <label class="sell__label">ブランド名</label>
                <input class="sell__input" type="text" name="brand_name" value="{{ old('brand_name') }}">
                @foreach ($errors->get('brand_name') as $message)
                    <p class="sell__error">{{ $message }}</p>
                @endforeach
                <label class="sell__label">商品の説明</label>
                <textarea class="sell__textarea" name="description">{{ old('description') }}</textarea>
                @foreach ($errors->get('description') as $message)
                    <p class="sell__error">{{ $message }}</p>
                @endforeach
                <label class="sell__label">販売価格</label>
                <div class="sell__price-wrap">
                    <span>¥</span>
                    <input class="sell__input sell__price-input" type="number" name="price" value="{{ old('price') }}">
                </div>
                @foreach ($errors->get('price') as $message)
                    <p class="sell__error">{{ $message }}</p>
                @endforeach
            </div>
            <button class="sell__button" type="submit">出品する</button>
        </form>
    </div>
@endsection