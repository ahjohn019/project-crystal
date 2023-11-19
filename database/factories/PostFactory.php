<?php

namespace Database\Factories;

use App\Http\Services\PostService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateByThisYear = fake()->dateTimeThisYear()->format('Y-m-d H:i:s');
        $likes = fake()->numberBetween(0, 100);
        $popularity = PostService::calculatePopularity($likes, 'likes')['popularity'];

        return [
            //
            'title' => fake()->name,
            'content' => fake()->sentence,
            'likes' => $likes,
            'popularity' => $popularity,
            'status' => fake()->numberBetween(0, 1),
            'user_id' => fake()->numberBetween(1, 4),
            'category_id' => fake()->numberBetween(1, 5),
            'created_at' => $dateByThisYear,
            'updated_at' => $dateByThisYear
        ];
    }
}
