@extends('layouts.app')
@section('content')
    <div class="profile-edit">
        <h2>プロフィール設定</h2>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-edit__image">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" width="100">
                @else
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: #ddd;"></div>
                @endif
            </div>
            <div class="profile-edit__form-group">
                <label for="profile_image">プロフィール画像</label>
                <input type="file" name="profile_image" id="profile_image">
                @foreach ($errors->get('profile_image') as $message)
                    <p>{{ $message }}</p>
                @endforeach
            </div>
            <div class="profile-edit__form-group">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
                @foreach ($errors->get('name') as $message)
                    <p>{{ $message }}</p>
                @endforeach
            </div>
            <div class="profile-edit__form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                @foreach ($errors->get('postal_code') as $message)
                    <p>{{ $message }}</p>
                @endforeach
            </div>
            <div class="profile-edit__form-group">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
                @foreach ($errors->get('address') as $message)
                    <p>{{ $message }}</p>
                @endforeach
            </div>
            <div class="profile-edit__form-group">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
                @foreach ($errors->get('building') as $message)
                    <p>{{ $message }}</p>
                @endforeach
            </div>
            <button type="submit">更新する</button>
        </form>
    </div>
@endsection