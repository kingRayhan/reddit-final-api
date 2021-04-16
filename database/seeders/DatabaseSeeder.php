<?php

namespace Database\Seeders;

use App\Models\Comment;
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

        $thread = Thread::factory()->create();

        Comment::factory()->count(2)->create(['thread_id' => $thread->id])
            ->each(function ($comment) use ($thread) {
                $this->createdNestedComments($comment, $thread);
            });

    }

    public function createdNestedComments($comment, $thread, $currentLevel = 0, $maxLevel = 2)
    {
        if ($maxLevel == $currentLevel) return;
        
        Comment::factory()->count(3)
            ->create(['thread_id' => $thread->id, 'parent_id' => $comment->id])
            ->each(function ($reply) use ($thread, $currentLevel) {
                $this->createdNestedComments($reply, $thread, ++$currentLevel);
            });
    }
}