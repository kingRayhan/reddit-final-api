<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * NotificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * All Notifications
     * @return mixed
     */
    public function notifications()
    {
        return NotificationResource::collection(auth()->user()->notifications);
    }

    /**
     * Unread notifications
     */
    public function unreadNotifications()
    {
        return NotificationResource::collection(auth()->user()->unreadNotifications);
    }

    /**
     * Get all read notifications
     * @return mixed
     */
    public function readNotifications()
    {
        return NotificationResource::collection(auth()->user()->readNotifications);
    }

    /**
     * Mark a notification as read
     * @param $notificationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->get()
            ->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(null, $notification ? 204 : 404);
    }

    /**
     * Mark a notification as unread
     * @param $notificationId
     */
    public function markAsUnread($notificationId)
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->get()
            ->first();
        if ($notification) {
            $notification->markAsUnread();
        }
        return response()->json(null, $notification ? 204 : 404);
    }

    /**
     * Clear all notifications
     */
    public function destroyAll()
    {
        auth()->user()->notifications()->delete();
        return response()->json(null, 204);
    }

    /**
     * Delete all unread notifications
     */
    public function destroyAllUnreads()
    {
        auth()->user()->unreadNotifications()->delete();
        return response()->json(null, 204);
    }

    /**
     * Delete all read notifications
     */
    public function destroyAllReads()
    {
        auth()->user()->readNotifications()->delete();
        return response()->json(null, 204);
    }


    public function destroy($notificationId)
    {
        // Credits: https://laracasts.com/discuss/channels/laravel/delete-notification
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->get()
            ->first();

        if ($notification) {
            $notification->delete();
        }

        return response()->json(null, $notification ? 204 : 404);
    }
}
