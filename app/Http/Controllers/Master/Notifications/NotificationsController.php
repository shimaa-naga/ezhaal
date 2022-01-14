<?php

namespace App\Http\Controllers\Master\Notifications;

use App\Http\Controllers\Controller;


class NotificationsController extends Controller
{
    protected function index()
    {
        // auth("web")->user()->notify(new FreelancerApplied(auth("web")->user(), 5));

        $notifications = \App\Help\Notification::getMasterNotifications();
        return view("master.notifications.index", compact("notifications"));
    }
    protected function read($id)
    {

        \App\Help\Notification::getMasterNotifications()
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })->markAsRead();
        $notifications = \App\Help\Notification::getMasterNotifications();

        return response()->json(["data" => view("master.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
    protected function readAll()
    {
        \App\Help\Notification::getMasterNotifications()->markAsRead();
        $notifications = \App\Help\Notification::getMasterNotifications();

        return response()->json(["data" => view("master.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
    protected function destroy($id)
    {
        \App\Help\Notification::getMasterNotifications()->where('id', $id)->first()->delete();
        $notifications = \App\Help\Notification::getMasterNotifications();

        return response()->json(["data" => view("master.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
    protected function destroyAll()
    {
        \App\Help\Notification::getMasterNotifications()->get()->delete();
        $notifications = \App\Help\Notification::getMasterNotifications();
        return response()->json(["data" => view("master.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
}
