<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '山本健太',
                'email' => 'yamamoto@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '宮下大輔',
                'email' => 'miyashita@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '佐々木美咲',
                'email' => 'sasaki@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '金雄ともみ',
                'email' => 'kanemoto@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '加藤雄太',
                'email' => 'kato@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '森越ももえ',
                'email' => 'moriwaka@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '中園ゆうみ',
                'email' => 'nakazono@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '村上信二',
                'email' => 'murakami@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
            [
                'name' => '中野こうたろう',
                'email' => 'nakano@example.com',
                'password' => Hash::make('password'),
                'profile_image' => 'items/watch.jpeg',
                'postal_code' => '100-0000',
                'address' => '東京都千代田区',
                'building' => '1-1'
            ],
        ]);
    }
}
