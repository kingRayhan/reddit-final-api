<?php

namespace App;

use App\Models\Comment;


trait NestableComment
{
    public static function nestedComments($thread_id, $page = 1, $limit = 10)
    {
        $comments = Comment::where('thread_id', $thread_id)->orderBy('created_at', 'desc');

        $groupedWithOutEagerLoadedUser = $comments->get()->groupBy('parent_id');
        if ($groupedWithOutEagerLoadedUser->isEmpty()) {
            return null;
        }

        $ids = self::getRootIds($groupedWithOutEagerLoadedUser, $page, $limit);
        $grouped = $comments->whereIn('id', $ids)->with('user')->get()->groupBy('parent_id');

        return self::buildNest($grouped->get(null), $grouped);
    }

    /**
     * Build nested comment
     * @param $comments
     * @param $groupComments
     * @param int $currentDepthLevel
     * @param int $maxDepthLevel
     * @return mixed|void
     */
    private static function buildNest($comments, $groupComments, $currentDepthLevel = 0, $maxDepthLevel = 4)
    {
        if ($currentDepthLevel == $maxDepthLevel) return;

        return $comments->each(function ($comment) use ($groupComments, $currentDepthLevel) {
            $replies = $groupComments->get($comment->id);
            if ($replies) {
                $comment->replies = $replies;
                self::buildNest($replies, $groupComments, ++$currentDepthLevel);
            } else {
                $comment->replies = [];
            }
        });
    }


    /**
     * Get root comments ids with pagination
     * @param $grouped
     * @param $page
     * @param $perPage
     * @return array|mixed
     */
    private static function getRootIds($grouped, $page, $perPage)
    {
        $root = $grouped->get(null)->forPage($page, $perPage);
        return self::buildIdNest($root, $grouped);
    }

    private static function buildIdNest($root, $grouped, &$ids = [])
    {
        foreach ($root as $comment) {
            $ids[] = $comment->id;
            if ($replies = $grouped->get($comment->id)) {
                self::buildIdNest($replies, $grouped, $ids);
            }
        }
        return $ids;
    }
}
