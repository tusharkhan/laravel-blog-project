<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 3,
            'password' => 'admin',
        ]);

        User::factory(70)->create();
        Category::factory(5)->create();
        Tag::factory(1000)->create();
        \App\Models\Post::factory(50)->create();
        \App\Models\Comment::factory(500)->create();

        // Create PostLinks for each post
        Post::all()->each(function ($post) {
            \App\Models\PostLink::factory(rand(2, 5))->create(['post_id' => $post->id]);
        });

        \App\Models\SiteSetting::create([
            'site_title' => 'Oredoo',
            'tagline' => 'Jamat Crimes',
            'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Porro tenetur non laudantium! Autem, similique. Error quidem sequi adipisci, voluptatem sunt possimus cum. Nisi, nobis quia! Odio, vel similique. Corrupti, a!',
            'logo_dark' => 'logo_dark.png',
            'logo_light' => 'logo_light.png',
            'copyright_text' => '© 2022, Oredoo, All Rights Reserved.',
            'enable_registration' => '1',
        ]);

        \App\Models\Menu::create([
            'header_menu' => json_encode([['href' => 'http://127.0.0.1:8000/', 'icon' => '', 'text' => 'Home', 'tooltip' => '', 'children' => []]]),
            'footer_menu' => json_encode([['href' => 'http://127.0.0.1:8000/', 'icon' => '', 'text' => 'Home', 'tooltip' => '', 'children' => []]]),
        ]);
    }
}
