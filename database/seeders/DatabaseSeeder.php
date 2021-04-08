<?php

namespace Database\Seeders;

use App\Models\Thread;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create 100 users and simultaneously create 50 threads for each user
         */
        \App\Models\User::factory(100)->create()->each(function ($user) {
            Thread::factory(50)->create(['user_id' => $user->id]);
        });


    }
}
