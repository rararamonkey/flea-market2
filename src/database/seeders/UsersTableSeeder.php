<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => '出品者',
                'password' => bcrypt('password'),
            ]
        );
    }
}