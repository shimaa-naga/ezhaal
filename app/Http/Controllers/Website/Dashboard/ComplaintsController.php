<?php


namespace App\Http\Controllers\Website\Dashboard;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\Complaints\ComplaintAttachments;
use App\Models\Complaints\ComplaintDetails;
use App\Models\Complaints\Complaints;
use App\Models\Complaints\ComplaintStatus;
use App\Models\Complaints\ComplaintTypeData;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{

    public function index()
    {
        $tickets = ComplaintDetails::where('by_id', auth()->guard('web')->user()->id)
            ->whereNull('reply_id')->orderByDesc('id')->get();
        //dd($tickets);
        return view('website.dashboard.complaints.index', compact('tickets'));
    }

    public function editTicket($complaintId){
        $complaint = Complaints::findOrFail($complaintId);
        $ticket = ComplaintDetails::where('complaint_id', $complaintId)->first();
        $replies =$complaint->replies();
        // ComplaintDetails::where('complaint_id', $complaintId)->whereNotNull('reply_id')->orderBy("id","desc")->get();
        $ticket_attachments = ComplaintAttachments::where('complaint_id', $ticket->id)->get();
        $complaint_type = ComplaintTypeData::where('type_id',$complaint->type_id)->where('lang_id', Utility::websiteLang())->first();

        return view('website.dashboard.complaints.edit_ticket', compact('ticket','replies','ticket_attachments','complaint_type'));
    }


    public function updateTicket(Request $request ,$complaintId)
    {
        //dd($request->all(), $complaintId);
        $complaint = Complaints::findOrFail($complaintId);
        $ticket = ComplaintDetails::where('complaint_id', $complaintId)->first();
        $ticket_reply = ComplaintDetails::create([
            'complaint_id' => $complaintId,
            'reply_id' => $ticket->id,
            'by_id' => auth()->guard('web')->user()->id ,
            'description' => $request->description,
            'created' => date('Y-m-d H:i:s'),
        ]);
        if($request->ticket_files != null){
            foreach($request->ticket_files as $key=>$ticket_file){
                $file = $request->file('ticket_files')[$key];
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = '/uploads/complaints/'. $complaintId;
                request()->file('ticket_files')[$key]->move(public_path($destinationPath), $filename);
                ComplaintAttachments::create([
                    'complaint_id' => $ticket_reply->id,
                    'file' => $destinationPath .'/'. $filename,
                    'file_type' => $file->getClientOriginalExtension(),
                    'created' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->back()->with('success', _i('Reply send successfully'));
    }

    public function deleteTicket($complaintId)
    {
        //dd($complaintId);
        Complaints::destroy($complaintId);
        return redirect()->route('website.complaints.index')->with('success', _i('Ticket deleted successfully'));
    }

    public function ticket()
    {
        $complaint_types = ComplaintTypeData::where('lang_id', Utility::websiteLang())->get();
        return view('website.dashboard.complaints.ticket', compact('complaint_types'));
    }

    public function open_ticket(Request $request)
    {
        if($request->next_value != 1 || $request->complaint_type == null){
            return redirect()->route('website.complaints.ticket')
                ->with('msg', _i('Please select the section most appropriate to the subject of the ticket'));
        }

        $ticket_type = $request->complaint_type;
        return view('website.dashboard.complaints.open_ticket', compact('ticket_type'));
    }

    public function send_ticket(Request $request)
    {
       // dd($request->all());

        //dd($request->file('ticket_files')[0], $request->all());
        $complaint = Complaints::create([
            'type_id' => $request->complaint_type,
            'status_id' => ComplaintStatus::first()->id,
            'created' => date('Y-m-d H:i:s'),
        ]);
        $complaint_details = ComplaintDetails::create([
           'complaint_id' => $complaint->id,
           'by_id' => auth()->guard('web')->user()->id ,
           'title' => $request->title,
           'description' => $request->description,
           'created' => date('Y-m-d H:i:s'),
        ]);
        if($request->ticket_files != null){
            foreach($request->ticket_files as $key=>$ticket_file){
                $file = $request->file('ticket_files')[$key];
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = '/uploads/complaints/'. $complaint->id;
                request()->file('ticket_files')[$key]->move(public_path($destinationPath), $filename);
                ComplaintAttachments::create([
                    'complaint_id' => $complaint_details->id,
                    'file' => $destinationPath .'/'. $filename,
                    'file_type' => $file->getClientOriginalExtension(),
                    'created' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->route('website.complaints.ticket')->with('success', _i('Ticket send successfully'));
    }
}
