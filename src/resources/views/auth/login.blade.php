@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
    <h1>ログイン</h1>

    <form action="/login" method="POST" novalidate>
        @csrf
        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @foreach($errors->get('email') as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>

        <div>
            <label>パスワード</label>
            <input type="password" name="password">
            @foreach($errors->get('password') as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>

        <button type="submit">ログイン</button>
    </form>
    <p><a href="/register">会員登録はこちら</a></p>
@endsection