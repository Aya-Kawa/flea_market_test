@extends('layouts.app')

@section('title', '会員登録')

@section('content')
    <h1>会員登録</h1>
    <form method="POST" action="/register" novalidate>
        @csrf

        <div>
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name')}}">
            @foreach($errors->get('name') as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>

        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email')}}">
            @foreach($errors->get('email') as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>

        <div>
            <label>パスワード</label>
            <input type="password" name="password" value="{{ old('password') }}">
            @foreach($errors->get('password') as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>

        <div>
            <label>パスワード確認</label>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
            @foreach($errors->get('password_confirmation') as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>

        <button type="submit">登録する</button>

    </form>

    <p><a href="/login">ログインはこちら</a></p>

@endsection