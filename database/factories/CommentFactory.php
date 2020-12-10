<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;


class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $total = Post::all()->count();
        return [
            'post_id' => $this->faker->numberBetween(1, $total),
            'email' => $this->faker->unique()->safeEmail,
            'text' => $this->faker->paragraph . $this->faker->paragraph,
        ];
    }
}
