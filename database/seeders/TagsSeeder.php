<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Marketing',
            'Technology',
            'Finance',
            'Development',
            'Startup',
            'Cloud',
            'E-learning',
            'Programming',
            'Web Development',
            'Mobile Development',
            'Software Engineering',
            'DevOps',
            'Cloud Computing',
            'Cybersecurity',
            'Machine Learning',
            'Data Science',
            'Git',
            'Startup',
            'SaaS',
            'IT Career',
            'Tech News',
        ];

        foreach ($tags as $tag) {
            \App\Models\Tags::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}
