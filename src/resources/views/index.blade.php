<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('items.index') }}" method="GET">
        <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="何をお探しですか">
        @if($tab === 'mylist'){
            <input type="hidden" name="tab" value="mylist">
        @endif
        <button type="submit">検索</button>
        }
    </form>

    <div>
        <a href="{{ route('items.index', ['keyword' => $keyword]) }}">おすすめ</a>
        <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => $keyword]) }}">マイリスト</a>
    </div>

    <h1>
        {{ $tab === 'mylist' ? 'マイリスト' : '商品一覧' }}
    </h1>

    @foreach ($items as $item)
        <div>
            <a href="/item/{{ $item->id }}">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
            </a>
            @if($item->purchases)
                <span class="sold">SOLD</span>
            @endif
            <div>商品名: {{ $item->name }}</div>
            <div>価格: {{ $item->price }}円</div>
            <div>出品者: {{ $item->user->name }}</div>
            <div>状態: {{ $item->condition->name }}</div>
        </div>
    @endforeach

    @if(Auth::check())
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    @endif
</body>

</html>