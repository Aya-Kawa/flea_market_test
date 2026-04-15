<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        if ($item->user_id === Auth::id()) {
            return redirect()->route('items.show', $item->id)->with('error', '自分の商品は購入できません。');
        }

        if ($item->purchases()->exists()) {
            return redirect()->route('items.show', $item->id)->with('error', 'この商品は既に購入されています。');
        }

        $purchaseAddress = session("purchase_address_{$item->id}", [
            'postal_code' => Auth::user()->postal_code,
            'address' => Auth::user()->address,
            'building' => Auth::user()->building,
        ]);

        $paymentMethod = session()->get("payment_method_{$item->id}", '');

        return view('purchase.create', compact('item', 'purchaseAddress', 'paymentMethod'));
    }



    public function store(Request $request, Item $item)
    {
        $paymentMethod = session()->get("payment_method_{$item->id}", 'コンビニ払い');

        $purchaseAddress = session()->get("purchase_address_{$item->id}", [
            'postal_code' => Auth::user()->postal_code,
            'address' => Auth::user()->address,
            'building' => Auth::user()->building,
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));


        $method = $paymentMethod;
        $paymentTypes = [];
        if ($method === 'カード払い') {
            $paymentTypes = ['card'];
        } elseif ($method === 'コンビニ払い') {
            $paymentTypes = ['konbini'];
        } else {
            $paymentTypes = ['card'];
        }

        $session = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => $paymentTypes,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]
            ],
            'success_url' => route('purchase.success', $item) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.cancel', $item),
            'metadata' => [
                'item_id' => $item->id,
                'user_id' => auth()->id(),
                'payment_method' => $request->payment_method ?? $paymentMethod,
                'postal_code' => $purchaseAddress['postal_code'],
                'address' => $purchaseAddress['address'],
                'building' => $purchaseAddress['building'] ?? '',
            ],
        ]);

        // Checkout ページへリダイレクト
        return redirect($session->url);
    }
    public function editAddress(Item $item)
    {
        $purchaseAddress = session()->get("purchase_address_{$item->id}", [
            'postal_code' => Auth::user()->postal_code,
            'address' => Auth::user()->address,
            'building' => Auth::user()->building,
        ]);

        return view('purchase.update', compact('item', 'purchaseAddress'));
    }

    public function success(Request $request, Item $item)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::retrieve($request->query('session_id'));

        if ($item->purchases()->exists()) {
            return redirect()->route('items.show', $item->id)->with('error', 'この商品は既に購入されています。');
        }

        Purchase::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'payment_method' => $session->metadata->payment_method,
            'postal_code' => $session->metadata->postal_code,
            'address' => $session->metadata->address,
            'building' => $session->metadata->building ?: null,
        ]);
        return redirect()->route('items.show', $item->id)->with('success', '決済が完了しました。');
    }

    public function cancel(Item $item)
    {
        return redirect()->route('purchase.create', $item->id)->with('error', '決済がキャンセルされました。');
    }

    public function updateAddress(AddressRequest $request, Item $item)
    {
        session()->put("purchase_address_{$item->id}", [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.create', $item->id)->with('success', '配送先住所が更新されました。');
    }

    public function updatePayment(Request $request, Item $item)
    {

        session()->put("payment_method_{$item->id}", $request->payment_method);

        return redirect()->route('purchase.create', $item->id)->with('success', '支払い方法が更新されました。');
    }

}
