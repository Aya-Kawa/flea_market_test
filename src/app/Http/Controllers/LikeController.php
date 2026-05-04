<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    //いいねが押されたらユーザーのログイン情報を取ってきて、DBに保存する
    //2回いいねできないようにする
    //もう一度押したらいいねがきえるようにする

    public function store($item_id)
    {
        $userId = auth()->id();

        $like = Like::where('user_id', $userId)->where('item_id', $item_id)->first();

        if ($like) {
            // すでにいいねされている場合は削除
            $like->delete();
        } else {
            // いいねを保存
            Like::create([
                'user_id' => $userId,
                'item_id' => $item_id,
            ]);

        }
        return redirect()->back();
    }
}
