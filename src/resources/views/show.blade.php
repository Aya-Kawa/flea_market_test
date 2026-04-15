<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
</head>

<body>
    <h1>{{ $item->name }}</h1>
    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
    <form action="{{ route('likes.store', ['item_id' => $item->id]) }}" method="POST">
        @csrf
        <button type="submit" class="like-btn">
            <span class="like-icon {{ $item->likes->contains('user_id', auth()->id()) ? 'liked' : ''}}">♥</span>
        </button>
    </form>

    <p>いいね数: {{ $item->likes->count() }}</p>
    <div>ブランド名: {{ $item->brand_name }}</div>
    <div>¥{{ number_format($item->price) }}</div>
    @auth
        <a href="{{ route('purchase.create', ['item' => $item->id]) }}" class="purchase-btn">ここで購入する</a>
    @else
        <a href="{{ route('login') }}" class="purchase-btn">購入するにはログインしてください</a>
    @endauth
    <h2>商品説明</h2>
    <p>{{ $item->description }}</p>
    <h2>商品の情報</h2>
    <div>カテゴリー:</div>
    　<ul>
        @foreach ($item->categories as $category)
            <li>{{ $category->name }}</li>
        @endforeach
    </ul>
    <div>商品の状態: {{ $item->condition->name }}</div>
    </div>
    <div>出品者: {{ $item->user->name }}</div>
    <div>状態: {{ $item->condition->name }}</div>

    <h2>コメント({{ $item->comments->count() }})</h2>
    @foreach($item->comments as $comment)
        <p>{{ $comment->user->name}} </p>
        <p>{{$comment->content}}</p>
    @endforeach

    @if(auth()->check())
        <form action=" {{ route('comments.store', ['item_id' => $item->id]) }}" method="POST">
            @csrf
            <textarea name="content"></textarea>

            @foreach($errors->get('content') as $message)
                <p>{{ $message }}</p>
            @endforeach

            <button type="submit">コメントを送信する</button>
    @endif
    </form>

</body>

</html>