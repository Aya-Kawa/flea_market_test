<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    //いいねが押されたらユーザーのログイン情報を取ってきて、DBに保存する
    //2回いいねできないようにする
    //もう一度押したらいいねがきえるようにする

    public function store($item_id)
    {
        $user = auth()->user();

        $like = Like::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if ($like) {
            // すでにいいねされている場合は削除
            $like->delete();
        } else {
            // いいねを保存
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item_id,
            ]);

        }
        return redirect()->back();
    }
}
