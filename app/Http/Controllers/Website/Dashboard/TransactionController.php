<?php

namespace App\Http\Controllers\Website\Dashboard;

use App\Help\Constants\BidStatus as ConstantsBidStatus;
use App\Help\Constants\PaymentStatus;

use App\Http\Controllers\Controller;
use App\Models\Discounts\Discount;
use App\Models\Financial\FinancialSettings;
use App\Models\Projects\BidStatus;
use App\Models\Projects\ProjectBids;
use App\Models\Projects\ProjectHistory;
use App\Models\Projects\Projects;
use App\Models\Transactions\Requests;
use App\Models\Transactions\Transaction;
use App\Notifications\TransactionRequested;
use App\Traits\Pricing;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    use Pricing;
    protected function index()
    {
        if (request()->ajax()) {
            $query = Transaction::join("project_history", "transactions.id", "project_history.transaction_id")
                ->join("project_bids", "project_history.bid_id", "project_bids.id")
                ->where("project_bids.freelancer_id", auth("web")->id())
                ->select("project_bids.*", "project_history.created_at as startdate");;


            return DataTables::eloquent($query)
                ->editColumn('created', function ($query) {
                    return $query->startdate = Carbon::parse($query->startdate)->format("d-m-Y");
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
                        $find = BidStatus::find($query->status_id);
                        if ($find != null)
                            return "<span class='badge badge-{$find->code}'>" . $find->title . "</span>";
                    }
                })
                ->addColumn("request", function ($query) {
                    if ($query->status_id != null) {
                        $find = BidStatus::where("title", ConstantsBidStatus::CLOSED)->first();
                        if ($find == null)
                            return;
                        if ($query->status_id == $find->id) {
                            if ($query->payment_status == PaymentStatus::PENDING) {
                                $finacial = FinancialSettings::take(1)->first();

                                $days = 1;
                                if ($finacial != null)
                                    $days = $finacial->holding_days;
                                $now = new Carbon();
                                $date =     Carbon::parse($query->startdate)->addDays($days);


                                if ($now->isAfter($date))
                                    return "<a href='transactions/request/{$query->id}'>" . _i('Request') . "</a>";
                                else
                                    return  $now->diffForHumans($date) . " " . $date;
                            } else if ($query->payment_status == PaymentStatus::PAID)
                                return "<span class='badge badge-success'>" . _i("Paid") . "</span>";
                            else if ($query->payment_status == PaymentStatus::REQUESTED)
                                return "<span class='badge badge-warning'>" . _i("Processing") . "</span>";
                        }
                    }
                })
                ->addColumn("title", function ($query) {
                    if ($query->project_id != null) {

                        $project = Projects::find($query->project_id);
                        if ($project != null)
                            return '<a href="' . url('project/' . $project->id . '/' . $project->title) . '" class="" title="' . _i("Show") . '">' . $project->title . "</a>";
                    }
                    // return '<a href="project/' . $query->id . '" class="" title="' . _i("Show") . '">' . $query->title . '</a>';
                })

                ->rawColumns([
                    "status",
                    "title",
                    "request"
                ])
                ->make(true);
        }
        return view("website.dashboard.transactions.index");
    }
    protected function onRequest($bid_id)
    {
        $bid = ProjectBids::find($bid_id);

        if ($bid == null)
            abort(404, "Bid Not Found");
        if ($bid->Freelancer()->id != auth("web")->id())
            abort(401, "You are not allowed to perform this action");
        $transaction = ProjectHistory::where("bid_id", $bid_id)->whereNotNull("transaction_id")->first();
        //dd($transaction);
        if ($transaction == null)
            abort(404, "Transaction Not found");
        if (Requests::where("bid_id", $bid_id)->first() != null) {
            $errors = new \Illuminate\Support\MessageBag();
            // add your error messages:
            $errors->add('sent_before', "Your request has been sent before.");
            return view("website.error")->withErrors($errors);
        }
        $finacial = FinancialSettings::take(1)->first();
        $days = 1;
        if ($finacial != null)
            $days = $finacial->holding_days;
        $now = new Carbon();
        $date = Carbon::parse($transaction->created_at)->addDays($days);
        if (!$now->isAfter($date)) {

            $errors = new \Illuminate\Support\MessageBag();
            // add your error messages:
            $errors->add('holding_days', $now->diffForHumans($date) . " " . _i("To request"));
            return view("website.error")->withErrors($errors);
        }
        $request_id =  Requests::create([
            "freelancer_id" => auth("web")->id(),
            "project_id" => $transaction->project_id,
            "bid_id" => $bid_id,
            "price" => $transaction->Transaction->user_amount
        ]);
        $bid->payment_status = PaymentStatus::REQUESTED;
        $bid->save();
        $role = \App\Help\Settings::GetOnrequestGroup();
        $find = Role::where("name", $role)->first();
        if ($find->null) {
            Notification::send($role, new TransactionRequested($request_id));
        }
        return view("website.thanks", [
            "title" => _i("Request Sent"),
            "msg" => _i("Your request has been sent to moderators.")
        ]);
    }
    // protected function show($id)
    // {

    //     if (!is_numeric($id))
    //         abort(404);

    //     $disabled = true;
    //     $project = Projects::find($id);
    //     if ($project->Owner()->id != auth("web")->user()->id) {
    //         abort(401);
    //     }
    //     if ($project == null)
    //         abort(404);
    //     $service = ($project->type == "service") ? true : false;

    //     if ($project->Status()->first()->title == ProjectStatus::OPEN && $project->Owner()->id == auth("web")->user()->id)
    //         return view("website.dashboard.project.edit", compact('project', "id", "service"));

    //     $limit = 10;
    //     $bids = ProjectBids::where("project_id", $id)->paginate($limit);
    //     if (request()->ajax()) {
    //         return view('website.dashboard.project_bids.parial.bids_actions_ajax', compact('bids'))->render();
    //     }
    //     return view("website.dashboard.project.show", compact('project', "id", "disabled", "bids"));
    // }
}
