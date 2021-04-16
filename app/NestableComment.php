<?php

namespace App;

trait NestableComment
{
    public function nestedComments($page = 1, $perpage = 10)
    {
        $comments = $this->comments();
        $grouped = $comments->with('user')->get()->groupBy('parent_id');
        $roots = $grouped->get(null);
        

        return $roots;


    }

    public function getIds($comments)
    {

    }

    public function buildNest($comments, $groupComments)
    {
        return $comments->each(function ($comment) use ($groupComments) {
            // Find replies by root level comment id
            $replies = $groupComments->get($comment->id);

            if ($replies) {
                // assign replies to children property
                $comment->children = $replies;
                $this->buildNest($replies, $groupComments);
            } else {
                $comment->children = [];
            }
        });
    }
}