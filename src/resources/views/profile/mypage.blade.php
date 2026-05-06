@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection
@section('content')
    <div class="mypage">
        <div class="mypage__profile">
            <div class="mypage__profile-left">
                @if ($user->profile_image)
                    <img class="mypage__profile-image" src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
                @else
                    <div class="mypage__profile-image--empty"></div>
                @endif
                <h2 class="mypage__name">{{ $user->name }}</h2>
            </div>
            <a class="mypage__edit-button" href="{{ route('profile.edit') }}">
                プロフィールを編集
            </a>
        </div>
        <div class="mypage__tabs">
            <a href="{{ route('mypage', ['tab' => 'sell']) }}" class="mypage__tab {{ $tab === 'sell' ? 'active' : '' }}">
                出品した商品
            </a>
            <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="mypage__tab {{ $tab === 'buy' ? 'active' : '' }}">
                購入した商品
            </a>
        </div>
        <div class="mypage__items">
            @foreach ($items as $item)
                <div class="item-card">
                    <a href="{{ route('items.show', $item->id) }}">
                        @if ($item->image_path)
                            <img class="item-card__image" src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
                        @else
                            <div class="item-card__image--empty">商品画像</div>
                        @endif
                        <p class="item-card__name">{{ $item->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection