<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticlesFactory extends Factory
{
    protected static $topics = [
        'marketing', 'technology', 'finance', 'development',
        'startup', 'cloud', 'e-learning'
    ];

    public function definition(): array
    {
        $topic = $this->faker->randomElement(self::$topics);
        $title = ucfirst($topic) . ': ' . $this->faker->sentence(4);

        return [
            'title'        => $title,
            'slug'         => Str::slug($title),
            'created_by'   => \App\Models\User::inRandomOrder()->first()->id,
            'summary'      => $this->faker->text(100),
            'content'      => $this->faker->paragraphs(3, true),
            'thumbnail'    => $this->faker->imageUrl(640, 480, $topic),
            'is_published' => $this->faker->boolean(70),
            'published_at' => now(),
        ];
    }
}
