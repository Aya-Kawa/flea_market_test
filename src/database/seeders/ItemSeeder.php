<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'user_id' => '1',
                'condition_id' => '1',
                'name' => '腕時計',
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'image_path' => 'items/watch.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '2',
                'condition_id' => '2',
                'name' => 'HDD',
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'image_path' => 'items/HDDDisk.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '3',
                'condition_id' => '3',
                'name' => '玉ねぎ3束',
                'brand_name' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'image_path' => 'items/Onion.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '4',
                'condition_id' => '4',
                'name' => '革靴',
                'brand_name' => null,
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'image_path' => 'items/Leather.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '5',
                'condition_id' => '1',
                'name' => 'ノートPC',
                'brand_name' => null,
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'image_path' => 'items/Laptop.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '6',
                'condition_id' => '2',
                'name' => 'マイク',
                'brand_name' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'image_path' => 'items/Music.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '7',
                'condition_id' => '3',
                'name' => 'ショルダーバッグ',
                'brand_name' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'image_path' => 'items/bag.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '8',
                'condition_id' => '4',
                'name' => 'タンブラー',
                'brand_name' => 'なし',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'image_path' => 'items/Tumbler.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '9',
                'condition_id' => '1',
                'name' => 'コーヒーミル',
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'image_path' => 'items/CoffeeMill.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '10',
                'condition_id' => '2',
                'name' => 'メイクセット',
                'brand_name' => null,
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'image_path' => 'items/MakeSet.jpg',
                'is_sold' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
