<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->count();
        return [
            'title' =>  $this->faker->words(12, true),
            'text' => $this->faker->paragraph . $this->faker->paragraph . $this->faker->paragraph,
            'user_id' => $this->faker->numberBetween(1, $users),
            'date' => date("Y-m-d"),
            'time' => date("H:i:s")
        ];
    }
}
