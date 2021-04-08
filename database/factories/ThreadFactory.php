<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $isTextThread = $this->faker->boolean;

        if ($isTextThread) {
            return [
                'title' => $this->faker->sentence,
                'text' => $this->faker->paragraph,
                'user_id' => User::factory(),
                'type' => 'TEXT'
            ];
        } else {
            return [
                'title' => $this->faker->sentence,
                'link' => $this->faker->url,
                'image' => $this->faker->imageUrl(),
                'user_id' => User::factory(),
                'type' => 'LINK'
            ];
        }

    }
}
