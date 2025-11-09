<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(table: 'blogs')->truncate();

        Blog::factory()
            ->count(30)
            ->create();

        // DB::table('blogs')->insert([
        //     'title' => 'blog 1',
        //     'description' => 'ini desc blog 1',
        // ]);

        // DB::table('blogs')->insert([
        //     'title' => 'blog 2',
        //     'description' => 'ini desc blog 2',
        // ]);
    }
}
