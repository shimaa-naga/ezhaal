<?php

namespace App\Http\Controllers\Master\Projects;


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

use App\User;
use Carbon\Carbon;

use Yajra\DataTables\Facades\DataTables;

class RequestsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Requests::
                //join("project_history", "transaction_requests.bid_id", "project_history.bid_id")
                join("project_bids", "transaction_requests.bid_id", "project_bids.id")

                ->select("project_bids.freelancer_id", "project_bids.status_id", "transaction_requests.price", "transaction_requests.project_id", "transaction_requests.id", "transaction_requests.bid_id", "project_bids.payment_status");


            return DataTables::eloquent($query)
                ->addColumn('created', function ($query) {
                    $find = ProjectHistory::whereNotNull("transaction_id")->where("bid_id", $query->bid_id)->first();
                    if ($find != null)
                        return Carbon::parse($find->created_at)->format("d-m-Y");
                })
                ->editColumn('price', function ($query) {
                    $price = $query->price;
                    if ($query->discount_id != null) {
                        $discount = Discount::find($query->discount_id);

                        if ($discount != null) {
                            if ($discount->type == "perc") {
                                $add = $query->price * $discount->price / 100;
                            } else
                                $add = $discount->price;
                            $price = ($price + $add) - $query->commession;
                        }
                    }
                    return $price;
                })->addColumn("status", function ($query) {
                    if ($query->status_id != null) {
                        $find = BidStatus::where("title", ConstantsBidStatus::CLOSED)->first();
                        if ($find == null)
                            return;
                        if ($query->status_id == $find->id) {
                            if ($query->payment_status == PaymentStatus::REQUESTED) {
                                $finacial = FinancialSettings::take(1)->first();
                                $days = 1;
                                if ($finacial != null)
                                    $days = $finacial->holding_days;
                                $now = new Carbon();

                                $trans = ProjectHistory::whereNotNull("transaction_id")->where("bid_id", $query->bid_id)->first();
                                if ($trans != null) {
                                    $startdate = Carbon::parse($trans->created_at)->format("d-m-Y");
                                    $date = Carbon::parse($startdate)->addDays($days);
                                    if ($now->isAfter($date))
                                        return "<span class='badge badge-danger'>" . _i('Pay Now') . "</span>";
                                    else
                                        return  "<span class='badge badge-warning'>" . $date . "</span>";
                                }
                                return  "<span class='badge badge-danger'>Error</span>";
                            } else if ($query->payment_status == PaymentStatus::PAID)
                                return "<span class='badge badge-success'>" . _i("Paid") . "</span>";
                            else if ($query->payment_status == PaymentStatus::PENDING)
                                return "<span class='badge badge-info'>" . _i("Pending") . "</span>";
                        }
                        return "<span class='badge badge-default'>" . $find->title . "</span>";


                        // $find = BidStatus::find($query->status_id);
                        // if ($find != null)
                        //     return "<span class='badge badge-{$find->code}'>" . $find->title . "</span>";
                    }
                })
                ->addColumn("request", function ($query) {
                    if ($query->status_id != null) {
                        $find = BidStatus::where("title", ConstantsBidStatus::CLOSED)->first();
                        if ($find == null)
                            return;
                        if ($query->status_id == $find->id) {

                            if ($query->payment_status == PaymentStatus::PENDING) {
                                return "<span class='badge badge-info'>" . _i("Pending") . "</span>";
                            } else if ($query->payment_status == PaymentStatus::PAID)
                                return "<span class='badge badge-success'>" . _i("Paid") . "</span>";
                            else if ($query->payment_status == PaymentStatus::REQUESTED)
                                return "<span class='badge badge-warning'>" . _i("On Request") . "</span>";
                        }
                    }
                })
                ->addColumn("title", function ($query) {
                    if ($query->project_id != null) {

                        $project = Projects::find($query->project_id);
                        if ($project != null)
                            return '<a href="requests/' . $query->id . '" class="" title="' . _i("Show") . '">' . $project->title . "</a>";
                    }
                    // return '<a href="project/' . $query->id . '" class="" title="' . _i("Show") . '">' . $query->title . '</a>';
                })->addColumn("freelancer", function ($query) {
                    if ($query->freelancer_id != null) {

                        $find = User::find($query->freelancer_id);
                        if ($find != null) {
                            if ($find->image != null && file_exists(public_path($find->image)))
                                $img = asset($find->image);
                            else $img = asset('uploads/users/user-default2.jpg');

                            return '<img class="circle"  width="50" height="50"  src="' . $img . '"> ' . $find->name;
                        }
                        return '<a href="project/' . $find->id . '" class="" title="' . _i("Show") . '">' . $find->name . "</a>";
                    }
                    // return '<a href="project/' . $query->id . '" class="" title="' . _i("Show") . '">' . $query->title . '</a>';
                })

                ->rawColumns([
                    "status",
                    "title",
                    "request", "freelancer"
                ])
                ->make(true);
        }
        return view("master.projects.requests.index");
    }

    protected function update( $id)
    {
        $request =request();
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
        return view("master.projects.requests.show", compact("bid", "project", "history", "date_info","requestObj"));
    }
}
