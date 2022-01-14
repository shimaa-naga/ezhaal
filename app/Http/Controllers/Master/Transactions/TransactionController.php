<?php

namespace App\Http\Controllers\Master\Transactions;


use App\Help\Constants\BidStatus as ConstantsBidStatus;
use App\Help\Constants\MimTypes;
use App\Help\Constants\PaymentStatus;
use App\Help\Utility;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\Discounts\Discount;
use App\Models\Financial\FinancialSettings;
use App\Models\Projects\BidStatus;

use App\Models\Projects\ProjectHistory;
use App\Models\Projects\Projects;
use App\Models\SiteSettings\Messages;
use App\Models\Transactions\Requests;
use App\Models\Transactions\Transaction;
use App\User;
use Carbon\Carbon;

use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $query = Transaction::join("project_history", "transactions.id", "project_history.transaction_id")
                ->join("project_bids", "project_history.bid_id", "project_bids.id")

                ->select("transactions.*",  "project_history.project_id", "project_history.bid_id");


            return DataTables::eloquent($query)
                ->addColumn('created', function ($query) {
                    return Carbon::parse($query->created_at)->format("D d-m-Y H:i:s");
                })

                ->addColumn("title", function ($query) {
                    if ($query->project_id != null) {

                        $project = Projects::find($query->project_id);
                        if ($project != null)
                            return '<a href="project/'.$query->project_id.'/show" class="" title="' . _i("Show") . '">' . $project->title . "</a>";
                    }

                })->editColumn("user_id", function ($query) {
                    if ($query->user_id != null) {

                        $find = User::find($query->user_id);
                        if ($find != null) {
                            if ($find->image != null && file_exists(public_path($find->image)))
                                $img = asset($find->image);
                            else $img = asset('uploads/users/user-default2.jpg');

                            return '<img class="circle"  width="50" height="50"  src="' . $img . '"> ' . $find->name;
                        }
                    }
                })->editColumn("method_id",function($q){
                    if($q->Method!=null)
                        return "<img src='".asset("payment_methods/".$q->Method->code).".svg' width='50px' alt='".$q->Method->title."'>" ;
                })
                ->editColumn("discount_id",function($q){
                    if($q->Discount!=null)
                        return ( ($q->Discount->type=="net")? "+" : "%"). $q->Discount->price ;
                })

                ->rawColumns([

                    "title", "user_id","method_id"

                ])
                ->make(true);
        }
        return view("master.transactions.index");
    }

    protected function update($id)
    {
        $request = request();
        $rules =  [
            'statement' => 'mimes:' . MimTypes::STATEMENT

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with("error", _i("Invalid file type"));
        }
        $requestObj = Requests::find($id);
        if ($requestObj == null)
            abort(404, "Can not find request object");
        $project = $requestObj->Project()->first();
        if ($requestObj == null)
            abort(404, "Can not find project object");
        $bid = $requestObj->Bid()->first();
        if ($bid == null)
            abort(404, "Can not find bid object");

        $destinationPath = Utility::PathCreate('app/uploads/projects/' . $project->id . "/statement/" . $bid->id, true);

        $filename = $request->statement->getClientOriginalName();
        $request->statement->move(storage_path($destinationPath), $filename);

        $requestObj->statement = storage_path($destinationPath) . "/" . $filename;
        $requestObj->statement_update = now();
        $requestObj->save();

        $bid->payment_status = PaymentStatus::PAID;
        $bid->save();

        return back()->with("success", _i("Updated successfully"));
    }
    protected function show($id)
    {
        $requestObj = Requests::find($id);
        if ($requestObj == null)
            abort(404);
        $bid = $requestObj->Bid()->first();
        if ($bid == null)
            abort(404, "Bid Not Found");


        $project = $requestObj->Project()->first();
        $freelancer = $bid->freelancer_id;
        $history = Messages::where("project_id", $project->id)->where(function ($q) use ($freelancer) {
            return $q->where("from_user", $freelancer)->orWhere("to_user", $freelancer);
        })->latest()->get();

        $finacial = FinancialSettings::take(1)->first();
        $days = 1;
        if ($finacial != null)
            $days = $finacial->holding_days;
        $now = new Carbon();
        $trans = ProjectHistory::whereNotNull("transaction_id")->where("bid_id", $bid->id)->first();
        if ($trans != null) {
            $startdate = Carbon::parse($trans->created_at)->format("d-m-Y");
            $date =     Carbon::parse($startdate)->addDays($days);
            if ($now->isAfter($date))
                $date_info = "<span class='badge badge-danger'>" . _i('Pay Now') . "</span>";
            else
                $date_info =  "<span class='badge badge-warning'>" . $date . "</span>";
        }
        return view("master.projects.requests.show", compact("bid", "project", "history", "date_info", "requestObj"));
    }
}
