<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Purchase;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // 商品の一覧を取得してビューに渡す
        //$items = Item::with('user', 'condition')->get();
        //return view('index', compact('items'));

        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        $query = Item::with('user', 'condition', 'likes', 'purchases');
        //商品の部分一致検索
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }
        if ($tab === 'mylist') {
            if (!auth()->check()) {
                $items = collect(); // ログインしていない場合は空のコレクションを返す
                return view('index', compact('query', 'tab', 'keyword', 'items'));
            }

            //いいねした商品だけ表示
            $query->whereHas('likes', function ($q) {//likesがある商品（item_id)を取ってくる。そこにさらに条件をつける
                $q->where('user_id', auth()->id());
            });
        } else {
            //おすすめ一覧では、自分が出品した商品を除外
            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());
            }
        }
        $items = $query->get();
        return view('index', compact('items', 'tab', 'keyword'));
    }

    public function show($id)
    {
        // 商品の詳細を取得してビューに渡す
        $item = Item::with(['user', 'condition', 'categories', 'likes', 'comments.user'])->findOrFail($id);

        return view('show', compact('item'));
    }
}
