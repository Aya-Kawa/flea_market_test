@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="items">
   <div class="items__tabs">       
        <a href="{{ route('items.index', ['keyword' => $keyword]) }}" class="items__tab {{$tab !=='mylist' ? 'items__tab--active':''}}">おすすめ</a>
        <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => $keyword]) }}" class="items__tab {{$tab ==='mylist' ? 'items__tab--active':''}}">マイリスト</a>
    </div>

<div class="items__list">
    @foreach ($items as $item)
    <div class="item-card">
    <a href="/item/{{ $item->id }}" class="item-card__link">
        <div class="item-card__image">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" >
                @if($item->purchases)
                <span class="item-card__sold">SOLD</span>
                @endif
        </div>
    </a>
            
            <div class="item-card__name">商品名: {{ $item->name }}</div>
    </div>
    @endforeach
</div>
    
@endsection
