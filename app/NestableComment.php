<?php

namespace App;

trait NestableComment
{
    public function nestedComments($page = 1, $perpage = 10)
    {
        $comments = $this->comments();
        $grouped = $comments->get()->groupBy('parent_id');
        $roots = $grouped->get(null);

        return $this->buildNest($roots, $grouped);
    }

    public function getIds($comments)
    {

    }

    public function buildNest($comments, $groupComments, $currentDepthLevel = 0, $maxDepthLevel = 4)
    {
        if ($currentDepthLevel == $maxDepthLevel) return;
        
        return $comments->each(function ($comment) use ($groupComments, $currentDepthLevel) {
            $replies = $groupComments->get($comment->id);
            if ($replies) {
                $comment->replies = $replies;
                $this->buildNest($replies, $groupComments, ++$currentDepthLevel);
            } else {
                $comment->replies = [];
            }
        });
    }
}