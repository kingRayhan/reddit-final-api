<?php

namespace Database\Seeders;

use App\Models\Thread;
use Illuminate\Database\Seeder;

class UserWithThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create 100 users and simultaneously create 50 threads for each user
         */
        \App\Models\User::factory(20)->create()->each(function ($user) {
            Thread::factory(10)->create(['user_id' => $user->id]);
        });
    }
}
