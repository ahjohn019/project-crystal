<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commentableIds = range(1, 500);
        shuffle($commentableIds);

        return [
            'commentable_id' => fake()->unique()->randomElement($commentableIds),
            'content' => fake()->sentence(),
            'commentable_type' => 'App\Models\Post',
            'status' => 1,
            'user_id' => fake()->numberBetween(1, 4)
        ];
    }
}
