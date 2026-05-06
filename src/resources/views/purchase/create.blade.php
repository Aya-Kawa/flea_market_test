@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}"
@endsection

@section('content')
<div class="purchase-container">
    <div class="purchase-left">


      <div class="purchase-item-area">

        <div class="purchase-item-image">
          <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>
        <div class="purchase-item-info">
          <h2>{{ $item->name }}</h2>
          <p>¥{{ number_format($item->price) }}</p>
        </div>
      </div>


      <div class="purchase-section">
        <h2>支払い方法</h2>

        <form action="{{ route('purchase.updatePayment', ['item' => $item->id]) }}" method="POST">
          @csrf
          <select name="payment_method" onchange="this.form.submit()">
            <option value="">選択してください</option>
            <option value="コンビニ払い" {{ $paymentMethod === 'コンビニ払い' ? 'selected' : '' }}>
              コンビニ払い
            </option>
            <option value="カード払い" {{ $paymentMethod === 'カード払い' ? 'selected' : '' }}>
              カード払い
            </option>
          </select>
           @foreach ($errors->get('payment_method') as $massage)
                <p class="form__error">{{ $massage }}</p>
            @endforeach
        </form>
      </div>

      <div>
        <div class="purchase-section">
          <div class="address-header">
            <h2>配送先</h2>
            <a href="{{ route('purchase.editAddress', ['item' => $item->id]) }}">変更する</a>
          </div>
          <p>〒{{ $purchaseAddress['postal_code'] }}</p>
          <p>{{ $purchaseAddress['address'] }}</p>
          <p>{{ $purchaseAddress['building'] }}</p>
            @foreach ($errors->get('shipping_address') as $massage)
                <p class="form__error">{{ $massage }}</p>
            @endforeach
          <input type="hidden" name="shipping_address" value="{{$purchaseAddress['postal_code']}} {{$purchaseAddress['address']}} {{$purchaseAddress['building'] ?? ''}}">
        </div>
      </div>
    </div>
  



  <div class="purchase-right">
    <table>
      <tr>
        <th>商品代金</th>
        <td>￥{{ number_format($item->price) }}</td>
      </tr>

      <tr>
        <th>支払い方法</th>
        <td>{{ $paymentMethod === '' ? '選択してください' : $paymentMethod }}</td>
      </tr>
    </table>

    <form action="{{ route('purchase.store', ['item' => $item->id]) }}" method="POST">
   @csrf
<input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
<input type="hidden" name="shipping_address" value="{{ $purchaseAddress['postal_code'] }} {{ $purchaseAddress['address'] }} {{ $purchaseAddress['building'] ?? '' }}">
<button type="submit">購入する</button>
</form>
  </div>
</div>
@endsection