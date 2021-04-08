<?php

namespace App\Http\Controllers;

use App\Http\Requests\Thread\StoreThreadRequest;
use App\Http\Requests\Thread\UpdateThreadRequest;
use App\Http\Resources\Thread\ThreadDetails;
use App\Http\Resources\Thread\ThreadList;
use App\Models\Thread;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])->except(['show', 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $threads = Thread::wherehas('user', function ($query) {
            $username = request()->query('username');
            if ($username)
                $query->where('username', $username);
            return $query;
        })
            ->with(['user', 'votes'])
            ->latest()
            ->paginate(request()->query('limit', 10));

        return ThreadList::collection($threads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreThreadRequest $request)
    {
        $thread = auth()->user()->threads()->create($request->all());

        return response()->json([
            'message' => 'Thread created',
            'data' => $thread
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Thread $thread
     * @return ThreadDetails
     */
    public function show(Thread $thread)
    {
        return new ThreadDetails($thread);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateThreadRequest $request, Thread $thread)
    {
        if ($request->type == 'LINK') {
            $thread->update([
                'title' => $request->title,
                'link' => $request->link,
                'image' => $request->image,
                'type' => 'LINK',
                'text' => null
            ]);
        } else {
            $thread->update([
                'title' => $request->title,
                'text' => $request->text,
                'type' => 'TEXT',
                'link' => null,
                'image' => null,
            ]);
        }

        return response()->json([
            'message' => 'Thread updated',
            'data' => $thread
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread);
        $thread->delete();
    }
}
