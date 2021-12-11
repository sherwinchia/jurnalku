<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'slug' => $this->faker->word() . '-' . sha1(time()) . '-' . $this->faker->numberBetween(0, 999999),
            'body' => $this->faker->paragraph(),
            'read_minutes' => "4 minutes",
            'published_at' => now(),
            'published' => 1
        ];
    }
}
