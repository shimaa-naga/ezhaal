<?php

namespace App\Http\Controllers\Website\Dashboard;



use App\Http\Controllers\Controller;


use App\Models\Projects\Projects;

use App\Models\SiteSettings\Messages;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{

    protected function store(Request $request)
    {
        $this->validate(request(), [
            'msg' => 'required',
        ]);

        $project = $request->input("project_id");
        if ($project != null && !is_numeric($project)) {
            $project = null;
        }

        $m =   Messages::create([
            "from_user" => auth("web")->user()->id,
            "to_user" => request()->input("to_id"),
            "body" => request()->input("msg"),
            "project_id" => $project,
            "subject" => request()->input("subject")

        ]);
        $m->message_id = $m->id;
        $m->save();

        return response()->json("SUCCESS");
    }

    public function index()
    {
        $limit = 10;
        $sub =Messages::groupBy('message_id')
        ->where('to_user', auth()->guard('web')->user()->id)
        ->select("message_id",DB::raw('MAX(id) AS max_id'));

        $messages = Messages::joinSub($sub,"sub",function ($join) {
            $join->on('messages.id', '=', 'sub.max_id');
        });
        //    SELECT M.*
        //    FROM messages M
        //    INNER JOIN
        //        (SELECT from_user, max(Id) as maxId
        //         FROM messages
        //         WHERE to_user = 20
        //         GROUP BY from_user)T
        //    ON M.Id = T.maxId



        if (request()->ajax()) {
            $messages = $messages->paginate($limit);
            return view('website.dashboard.messages.partial.message_ajax', compact('messages'))->render();
        }
        $messages = $messages->paginate($limit);
        return view('website.dashboard.messages.index', compact('messages'));
    }


    public function read_message($id)
    {
        $message = Messages::where('id', $id)->where('to_user', auth()->guard('web')->user()->id)->first();
        $history = Messages::where('message_id', $message->message_id)->orderBy("id","desc")->get();
        if ($message != null) {
            $message->update(['read_at' => date('Y-m-d H:i:s')]);
            return view('website.dashboard.messages.show', compact('history'));
        } else {
            abort(404);
        }
    }

    public function msg_reply($id, Request $request)
    {
        $message = Messages::findOrFail($id);
        $msg_id = $message->id;
        if ($message->message_id != null)
            $msg_id = $message->message_id;
        Messages::create([
            'from_user' => auth()->guard('web')->user()->id,
            'to_user' => $message->from_user,
            'message_id' => $msg_id,
            'subject' => $message->subject,
            'project_id' => $message->project_id,
            'body' => $request->reply_msg,
        ]);

        return redirect()->back()->with('success', _i('Sent successfully'));
    }

    public function destroy($id)
    {
        Messages::destroy($id);
        if (request()->ajax()) {
            return response(["data" => true]);
        } else {
            return redirect()->route('website.message.index')->with('success', _i('Deleted successfully'));
        }
    }
}
