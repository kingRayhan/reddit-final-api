<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

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
        // $isTextThread = $this->faker->boolean;
        $isTextThread = false;


        $memeAPI = Http::get('https://meme-api.herokuapp.com/gimme');



        if ($isTextThread) {
            return [
                // 'title' => $this->faker->sentence,
                'title' => $memeAPI->json('title'),
                'text' => $this->faker->paragraph,
                'user_id' => User::all()->random()->id,
                'type' => 'TEXT'
            ];
        } else {
            return [
                // 'title' => $this->faker->sentence,
                'title' => $memeAPI->json('title'),
                'link' => $memeAPI->json('url'),
                'image' => $memeAPI->json('url'),
                'user_id' => User::all()->random()->id,
                'type' => 'LINK'
            ];
        }
    }
}
