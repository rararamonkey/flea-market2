<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create([
            'user_id' => 1,
            'item_id' => 1,
            'content' => 'とても使いやすそうです！',
        ]);

        Comment::create([
            'user_id' => 1,
            'item_id' => 1,
            'content' => '購入を検討しています。',
        ]);
    }
}
