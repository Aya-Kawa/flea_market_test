<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell.create', compact('categories', 'conditions'));
    }
    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();
        $imagePath = $request->file('image')->store('items', 'public');
        $item = Item::create([
            'user_id' => Auth::id(),
            'condition_id' => $validated['condition_id'],
            'name' => $validated['name'],
            'brand_name' => $validated['brand_name'] ?? null,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_path' => $imagePath,
        ]);
        $item->categories()->attach($validated['categories']);
        return redirect('/')
            ->with('message', '商品を出品しました');
    }
}
