<?php

namespace App\Http\Controllers\Master\Complaints;

use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Mail\TicketReply;
use App\Models\Complaints\ComplaintAttachments;
use App\Models\Complaints\ComplaintDetails;
use App\Models\Complaints\Complaints;
use App\Models\Complaints\ComplaintStatusData;
use App\Models\Complaints\ComplaintStatusHistory;
use App\Models\Complaints\ComplaintType;
use App\Models\Complaints\ComplaintTypeData;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ComplaintsController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Complaints::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)
                ->addColumn('title', function ($query) {
                    $query_data = ComplaintDetails::where('complaint_id', $query->id)->first();
                    return $query_data != null ? $query_data->title : '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('No complaint title') . '</a>';
                })
                ->editColumn('type_id', function ($query) {
                    $query_data = ComplaintTypeData::where('type_id', $query->type_id)->where('lang_id', Utility::getLang())->first();
                    return $query_data != null ? $query_data->title : '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('Complaint type not translated yet') . '</a>';
                })
                ->editColumn('status_id', function ($query) {
                    $query_data = ComplaintStatusData::where('status_id', $query->status_id)->where('lang_id', Utility::getLang())->first();
                    return $query_data != null ? $query_data->title : '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('Complaint status not translated yet') . '</a>';
                })
                ->addColumn('options', function ($query) {
                    $html = '
                    	<a href ="' . route('master.complaints.show', $query->id) . '" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Show Complaint") . '" >
							<i class="fa fa-eye"></i>
						</a>  &nbsp;';
                    return $html;
                })
                ->rawColumns([
                    'title',
                    'type_id',
                    'status_id',
                    'options'
                ])
                ->make(true);
        }
        return view('master.complaints.index');
    }

    public function show($complaintId)
    {
        $complaint = Complaints::findOrFail($complaintId);
        $complaint_details = ComplaintDetails::where('complaint_id', $complaintId)->whereNull('reply_id')->first();
        $complaint_user = User::where('id', $complaint_details->by_id)->first();
        $complaint_attachments = ComplaintAttachments::where('complaint_id', $complaint_details->id)->get();
        $complaint_types = ComplaintTypeData::where('lang_id', Utility::getLang())->get();
        $complaint_status = ComplaintStatusData::where('lang_id', Utility::getLang())->get();
        $complaint_replies = ComplaintDetails::where('complaint_id', $complaintId)->whereNotNull('reply_id')->orderBy("id", "Desc")->get();
        $complaint_replies = ($complaint->replies());
        // dd($complaint_replies);
        return view('master.complaints.show', compact(
            'complaint',
            'complaint_details',
            'complaint_attachments',
            'complaint_user',
            'complaint_types',
            'complaint_status',
            'complaint_replies'
        ));
    }

    public function status(Request $request, $id)
    {

        $complaint = Complaints::findOrFail($id);
        $complaint->update(['status_id' => $request->status_id, "type_id" => $request->type_id]);

        ComplaintStatusHistory::create([
            'complaint_id' => $id,
            'status_id' => $request->status_id,
            'by_id' => auth()->id(),
            'created' => date('Y-m-d h:i:s'),
        ]);
        return redirect()->back()->with('success', _i('Updated Successfully'));
    }
    public function reply(Request $request)
    {

        $complaint = Complaints::findOrFail($request->complaintId);


        if ($request->reply_to_complaint != null) {
            $details = ComplaintDetails::create([
                'complaint_id' => $request->complaintId,
                //'by_id' => auth()->guard('master')->user()->id,
                'by_id' => auth()->id(),
                'reply_id' => $request->complaintDetailsId,
                'description' => $request->reply_to_complaint,
                'created' => date('Y-m-d h:i:s'),
            ]);
        }


        if ($request->ticket_files != null) {
            foreach ($request->ticket_files as $key => $ticket_file) {
                $file = $request->file('ticket_files')[$key];
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = '/uploads/complaints/' . $request->complaintId;
                request()->file('ticket_files')[$key]->move(public_path($destinationPath), $filename);
                ComplaintAttachments::create([
                    'complaint_id' => $details->id,
                    'file' => $destinationPath . '/' . $filename,
                    'file_type' => $file->getClientOriginalExtension(),
                    'created' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        $to = $complaint->authorDetails()->first()->by->email;
        try {
            Mail::to($to)->send(new TicketReply($complaint, $request->reply_to_complaint, auth()->user()));
        } catch (Exception $ex) {
        return redirect()->back()->with('error', $ex->getMessage());

        }

        return redirect()->back()->with('success', _i('Saved Successfully'));
    }
}
