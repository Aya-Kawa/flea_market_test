@extends('layouts.app')
@section('content')
    <div class="mypage">
        <div class="mypage__profile">
            <div class="mypage__profile-left">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" width="100">
                @else
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: #ddd;"></div>
                @endif
                <h2>{{ $user->name }}</h2>
            </div>
            <div class="mypage__profile-right">
                <a href="{{ route('profile.edit') }}">プロフィールを編集</a>
            </div>
        </div>
        @if (session('message'))
            <p>{{ session('message') }}</p>
        @endif

        <div class="mypage__tabs">
            <div class="mypage__tab">
                <h3>出品した商品</h3>
                <p>まだ出品した商品はありません</p>
            </div>
            <div class="mypage__tab">
                <h3>購入した商品</h3>
                @forelse ($user->purchases as $purchase)
                    <div class="mypage__item">
                        @if ($purchase->item && $purchase->item->image_path)
                            <img src="{{ asset('storage/' . $purchase->item->image_path) }}" alt="商品画像" width="120">
                        @endif
                        <p>{{ $purchase->item->name ?? '商品名未設定' }}</p>
                    </div>
                @empty
                    <p>購入した商品はありません</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection