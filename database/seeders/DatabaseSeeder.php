<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
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
        // User::factory()->count(15)->create();
        Thread::factory()->count(200)->create();
    }

    public function nestedCommentGeneration()
    {
        $thread = Thread::factory()->create();
        Comment::factory()->count(100)->create(['thread_id' => $thread->id])
            ->each(function ($comment) use ($thread) {
                $this->createdNestedComments($comment, $thread);
            });
    }

    public function createdNestedComments($comment, $thread, $currentLevel = 0, $maxLevel = 3)
    {
        if ($maxLevel == $currentLevel) return;

        Comment::factory()->count(3)
            ->create(['thread_id' => $thread->id, 'parent_id' => $comment->id])
            ->each(function ($reply) use ($thread, $currentLevel) {
                $this->createdNestedComments($reply, $thread, ++$currentLevel);
            });
    }
}
