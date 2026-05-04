@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-detail">

    <div class="item-detail__image">
        @if ($item->image_path)
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
        @else
            <span>商品画像</span>
        @endif
    </div>

    <div class="item-detail__content">

        <h1 class="item-detail__title">{{ $item->name }}</h1>

        <p class="item-detail__brand">
            {{ $item->brand_name }}
        </p>

        <p class="item-detail__price">
            ¥{{ number_format($item->price) }} <span>税込</span>
        </p>

        <div class="item-detail__actions">
            <form action="{{ route('likes.store', ['item_id' => $item->id]) }}" method="POST">
                @csrf
                <button type="submit" class="like-btn">
                    <span class="like-icon {{ $item->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}">
                        ♥
                    </span>
                </button>
                <p>{{ $item->likes->count() }}</p>
            </form>

            <div class="comment-count">
                <span>💬</span>
                <p>{{ $item->comments->count() }}</p>
            </div>
        </div>

        @auth
            <a href="{{ route('purchase.create', ['item' => $item->id]) }}" class="purchase-btn">
                購入手続きへ
            </a>
        @else
            <a href="{{ route('login') }}" class="purchase-btn">
                購入するにはログインしてください
            </a>
        @endauth

        <section class="item-section">
            <h2>商品説明</h2>
            <p>{{ $item->description }}</p>
        </section>

        <section class="item-section">
            <h2>商品の情報</h2>

            <div class="item-info">
                <div class="item-info__row">
                    <p class="item-info__label">カテゴリー</p>
                    <div class="item-info__value">
                        @foreach ($item->categories as $category)
                            <span class="category-tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="item-info__row">
                    <p class="item-info__label">商品の状態</p>
                    <p class="item-info__value">{{ $item->condition->name }}</p>
                </div>
            </div>
        </section>

        <section class="item-section">
            <h2>コメント({{ $item->comments->count() }})</h2>

            @foreach($item->comments as $comment)
                <div class="comment">
                    <div class="comment__user">
                        <div class="comment__icon">
                          <img src="asset{{asset('storage/'.$comment->user->profile_image)}}" alt="">
                         </div>
                        <span>{{ $comment->user->name }}</span>
                    </div>
                    <div class="comment__content">
                    {{ $comment->content }}
                    </div>
                </div>
            @endforeach

            @auth
                <form action="{{ route('comments.store', ['item_id' => $item->id]) }}" method="POST" class="comment-form">
                    @csrf

                    <label class="comment-form__label">商品へのコメント</label>
                    <textarea name="content" class="comment-form__textarea"></textarea>

                    @error('content')
                        <p class="form__error">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="comment-form__button">
                        コメントを送信する
                    </button>
                </form>
            @endauth

        </section>

    </div>
</div>
@endsection