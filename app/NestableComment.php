<?php

namespace App;

trait NestableComment
{
    public function nestedComments($page = 1, $limit = 10)
    {
        $comments = $this->comments();
        $grouped = $comments->with('user')->get()->groupBy('parent_id');
        $roots = $grouped->get(null)->forPage($page, $limit);
        return $this->buildNest($roots, $grouped);
    }

    /**
     * Build nested comment
     * @param $comments
     * @param $groupComments
     * @param int $currentDepthLevel
     * @param int $maxDepthLevel
     * @return mixed|void
     */
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