<?php

namespace Database\Seeders;

use App\Models\Articles;
use App\Models\ArticleTags;
use App\Models\Tags;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TagsSeeder::class
        ]);

        User::factory()->count(30)->create();
        Articles::factory()->count(30)->create();

        $articles = Articles::all();
        $tagIds = Tags::pluck('id')->toArray();

        foreach ($articles as $article) {
            $tags = collect($tagIds)->random(rand(1, 3))->all();

            foreach ($tags as $tagId) {
                ArticleTags::create([
                    'article_id' => $article->id,
                    'tag_id'     => $tagId,
                ]);
            }
        }
    }
}
