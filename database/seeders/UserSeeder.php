<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)
            ->state(function () {
                return [
                    'avatar_url' => 'https://placekitten.com/g/150/150',
                    'email' => 'xxx1@gmail.com',
                    'github_id' => 1
                ];
            })
            ->has(Post::factory()->count(100), 'posts')
            ->create();

        \App\Models\User::factory(1)
            ->state(function () {
                return [
                    'avatar_url' => 'https://placekitten.com/g/151/151',
                    'email' => 'xxx2@gmail.com',
                    'github_id' => 2
                ];
            })
            ->has(Post::factory()->count(100), 'posts')
            ->create();

        \App\Models\User::factory(1)
            ->state(function () {
                return [
                    'avatar_url' => 'https://placekitten.com/g/152/152',
                    'email' => 'xxx3@gmail.com',
                    'github_id' => 3
                ];
            })
            ->has(Post::factory()->count(100), 'posts')
            ->create();  
    }
}
