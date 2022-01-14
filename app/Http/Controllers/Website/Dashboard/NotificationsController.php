<?php

namespace App\Http\Controllers\Website\Dashboard;

use App\Http\Controllers\Controller;


class NotificationsController extends Controller
{
    protected function index()
    {
       // auth("web")->user()->notify(new FreelancerApplied(auth("web")->user(), 5));

        $notifications = auth()->user()->Notifications;
        return view("website.dashboard.notifications.index", compact("notifications"));
    }
    protected function read($id)
    {
        auth()->user()->unreadNotifications
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })->markAsRead();
        $notifications = auth()->user()->Notifications;

        return response()->json(["data" => view("website.dashboard.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
    protected function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $notifications = auth()->user()->Notifications;

        return response()->json(["data" => view("website.dashboard.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
    protected function destroy($id)
    {
        auth("web")->user()->notifications()->where('id', $id)->delete();
        $notifications = auth()->user()->Notifications;

        return response()->json(["data" => view("website.dashboard.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
    protected function destroyAll()
    {
        auth("web")->user()->notifications()->delete();
        $notifications = auth()->user()->Notifications;
        return response()->json(["data" => view("website.dashboard.notifications.render.index", compact("notifications"))->render(), "status" => "ok"]);
    }
}
