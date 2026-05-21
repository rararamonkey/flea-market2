<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'seller@test.com')->first();

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition' => '良好',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
        ]);
        $item->categories()->attach([1, 5]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'HDD',
            'brand' => '西芝',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'condition' => '目立った傷や汚れなし',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
        ]);
        $item->categories()->attach([2]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '玉ねぎ3束',
            'brand' => 'なし',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition' => 'やや傷や汚れあり',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
        ]);
        $item->categories()->attach([10]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => '革靴',
            'brand' => '',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'condition' => '状態が悪い',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
        ]);
        $item->categories()->attach([1, 5]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'ノートPC',
            'brand' => '',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'condition' => '良好',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
        ]);
        $item->categories()->attach([2]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'マイク',
            'brand' => 'なし',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'condition' => '目立った傷や汚れなし',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
        ]);
        $item->categories()->attach([2]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'ショルダーバッグ',
            'brand' => '',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'condition' => 'やや傷や汚れあり',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
        ]);
        $item->categories()->attach([1, 4]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'タンブラー',
            'brand' => 'なし',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'condition' => '状態が悪い',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
        ]);
        $item->categories()->attach([10]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'condition' => '良好',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
        ]);
        $item->categories()->attach([10]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'メイクセット',
            'brand' => '',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'condition' => '目立った傷や汚れなし',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
        ]);
        $item->categories()->attach([6, 4]);
    }
}