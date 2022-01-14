<?php

namespace App\Http\Controllers\Website\Dashboard;

use App\Bll\Bid;
use App\Help\Constants\BidStatus as ConstantsBidStatus;

use App\Help\Constants\ProjectStatus;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\Projects\BidAttachements;
use App\Models\Projects\BidCommission;
use App\Models\Projects\BidStatus;
use App\Models\Projects\ProjectBids;
use App\Models\Projects\ProjectHistory;
use App\Models\Projects\Projects;
use App\Models\Projects\ProjStatus;
use App\Models\Projects\Works;
use App\Models\SiteSettings\Commissions;
use App\Models\SiteSettings\Messages;
use App\Notifications\BidCompleted;
use App\Notifications\FreelancerApplied;
use App\Notifications\FreelancerRejected;

use App\Traits\Pricing;
use App\Transaction as AppTransaction;
use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class ProjectBidController extends Controller
{
     use Pricing;
    protected function index($id)
    {

        if (!is_numeric($id))
            abort(404);
        $project = Projects::find($id);
        if ($project == null)
            abort(404);

        $disabled = false;
        if (auth("web")->user() != null) {
            if (ProjectBids::where("project_id", $id)->where("freelancer_id", auth("web")->user()->id)->first() != null)
                $disabled = true;
            if ($project->Owner()->id == auth("web")->user()->id)
                $disabled = true;
        }
        if ($project->Status()->first()->title != ProjectStatus::PUBLISHED)
            $disabled = true;

        $limit = 2;

        $bids = ProjectBids::where("project_id", $id)->paginate($limit);
        if (request()->ajax()) {
            return view('website.dashboard.project_bids.parial.bids_ajax', compact('bids'))->render();
        }
        $eq = $this->GetCommissionJSEquation();
        $discount = $this->GetDiscount();

        $eqDiscount = $this->GetDiscountJSEquation();

        return view("website.dashboard.project_bids.index", compact('project', "id", "disabled", "bids", "eq", "discount", "eqDiscount"));
    }
    protected function show($id)
    {


        if (!is_numeric($id))
            abort(404);
        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404);
        if ($bid->Project()->owner_id != auth("web")->user()->id) {
            abort(401);
        }
        $project = $bid->Project();

        $freelancer = $bid->freelancer_id;
        $history = Messages::where("project_id", $project->id)->where(function ($q) use ($freelancer) {
            return $q->where("from_user", $freelancer)->orWhere("to_user", $freelancer);
        })->latest()->get();
        return view("website.dashboard.project_bids.show", compact("bid", "project", "history"));
    }
    protected function download($id)
    {
        //This method will look for the file and get it from drive
        $works = Works::find($id);
        if ($works == null)
            abort(404);
        if ($works->Bid()->first()->freelancer_id != auth("web")->id() && $works->Bid()->first()->Project()->owner_id != auth("web")->id()) {
            abort(401);
        }
        $path = storage_path($works->file);
        try {
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } catch (FileNotFoundException $exception) {
            abort(404);
        }
    }
    protected function saveMyWork($id)
    {
        if (!is_numeric($id))
            abort(404);
        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404);

        if ($bid->freelancer_id != auth("web")->id()) {
            abort(401);
        }

        $attached = request()->file("upload");
        // dd($attached);
        if ($attached != null) {
            $destinationPath = 'app/uploads/projects/' . $bid->Project()->id . "/work/" . $bid->id;
            Utility::PathCreate($destinationPath, true);
            $filename = $attached->getClientOriginalName();
            $attached->move(storage_path($destinationPath), $filename);
            Works::create([
                "bid_id" => $bid->id,
                "file" => $destinationPath . '/' . $filename,
                "description" => request()->input("desc")
            ]);
        }
        return redirect()->to("dash/bid/my/" . $bid->id . "#close");
    }
    protected function mySingleBid($id)
    {
        if (!is_numeric($id))
            abort(404);
        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404);

        if ($bid->freelancer_id != auth("web")->id()) {
            abort(401);
        }
        $project = $bid->Project();
        $freelancer = $bid->freelancer_id;
        $history = Messages::where("project_id", $project->id)->where(function ($q) use ($freelancer) {
            return $q->where("from_user", $freelancer)->orWhere("to_user", $freelancer);
        })->latest()->get();
        return view("website.dashboard.project_bids.my.single", compact("bid", "project", "history"));
    }
    protected function myBids(HttpRequest $request)
    {
        $limit = 10;
        $projects = Projects::join("project_bids", "projects.id", "project_bids.project_id")
            ->where("freelancer_id", auth("web")->user()->id)

            ->select("projects.id", "projects.owner_id", "projects.budget", "projects.duration", "project_bids.id as bid_id", "projects.title", "project_bids.price", "project_bids.commession", "project_bids.duration", "project_bids.created_at")->orderby("bid_id", "desc");

        if ($request->input("state") != null) {

            $projects = $projects->whereIn("project_bids.status_id", $request->input("state"));
        }
        if ($request->input("title") != null) {

            $projects = $projects->where("projects.title", "iLike", "%" . $request->input("title") . "%");
        }

        $projects = $projects->paginate($limit);

        if (request()->ajax()) {
            return view('website.dashboard.project_bids.my.all.ajax', compact('projects'))->render();
        }
        $selecetedState = "";
        return view("website.dashboard.project_bids.my.all", compact("projects", "selecetedState"));
    }
    protected function complete($id)
    {
        if (!is_numeric($id))
            abort(404);

        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404);
        if ($bid->freelancer_id != auth("web")->id())
            abort(401);
        try {
            DB::transaction(function () use ($bid) {
                $bid->status_id = BidStatus::firstOrCreate(["title" => ConstantsBidStatus::COMPLETED])->id;
                $bid->save();
                $project = $bid->Project();
                $status_id = ProjStatus::firstOrCreate(["title" => ProjectStatus::COMPLETED])->id;
                $project->update([
                    "status_id" => $status_id
                ]);
                $project->StatusLog()->attach($status_id, ["by_id" => auth("web")->user()->id, "bid_id" => $bid->id, "created_at" => Carbon::now()]);
            });
            $bid->Project()->owner()->notify(new BidCompleted($bid->id));
        } catch (Exception $exc) {
            return back()->with("error", $exc->getMessage());
        }
        return back()->with("success", _i("Completed successfully."));
    }
    protected function close($id)
    {
        if (!is_numeric($id))
            abort(404);

        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404);
        if ($bid->Project()->owner_id != auth("web")->id())
            abort(401);
        try {
            DB::transaction(function () use ($bid) {
                $bid->status_id = BidStatus::firstOrCreate(["title" => ConstantsBidStatus::CLOSED])->id;
                $bid->save();
                $project = $bid->Project();
                $status_id = ProjStatus::firstOrCreate(["title" => ProjectStatus::CLOSED])->id;
                $project->update([
                    "status_id" => $status_id
                ]);
                $project->StatusLog()->attach($status_id, ["by_id" => auth("web")->user()->id, "bid_id" => $bid->id, "created_at" => Carbon::now()]);
            });
        } catch (Exception $exc) {
            return back()->with("error", $exc->getMessage());
        }
        return back()->with("success", _i("Closed successfully."));
    }
    protected function accept($id)
    {
        if (!is_numeric($id))
            abort(404);

        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404);
        if ($bid->Project()->owner_id != auth("web")->id())
            abort(401);
        try {

            $category = $bid->Project()->category_id;
            $comm = $this->GetCommission($bid->price, $category);
            //project
            $bid->commession = $comm;
            $bid->save();

            $trans = new AppTransaction();
            return $trans->bid($bid->id, $bid->price, $category);
        } catch (Exception $exc) {
            return back()->with("error", $exc->getMessage());
        }
        return back()->with("success", _i("Accepted successfully."));
    }
    protected function reject($id)
    {
        if (!is_numeric($id))
            abort(404);
        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404);
        if ($bid->Project()->owner_id != auth("web")->id())
            abort(401);
        try {
            DB::transaction(function () use ($bid) {
                $bid->status_id = BidStatus::firstOrCreate(["title" => ConstantsBidStatus::REJECTED])->id;
                $bid->save();
                ProjectHistory::create(["project_id" => $bid->Project()->id, "bid_id" => $bid->id, "status" => ProjectStatus::REJECTED, "by_id" => auth("web")->id()]);
            });
            $bid->Freelancer()->notify(new FreelancerRejected($bid->id));
        } catch (Exception $exc) {
            return back()->with("error", $exc->getMessage());
        }
        return back()->with("success", _i("Rejected successfully."));
    }
    protected function store($id)
    {
        if (!is_numeric($id))
            abort(404);
        $project = Projects::find($id);
        if ($project == null)
            abort(404);

        $bll = new Bid();
        $res =  $bll->create(request(), auth()->user()->id, $id);
        if(!$res)
        {
            return back()->with("error", "Invalid Oprtation");
        }

        // $this->validate(request(), [
        //     'duration' => 'numeric',
        //     'budget' => 'required', 'numeric',
        //     'desc' => 'required'
        // ]);
        // try {
        //     $id =  DB::transaction(function () use ($project) {
        //         $request = request();
        //         //project
        //         $bid =  ProjectBids::create([
        //             "project_id" => $project->id,
        //             "description" => $request->input("desc"),
        //             "duration" => $request->input("duration"),
        //             "price" => $request->input("budget"),
        //             "freelancer_id" => auth("web")->user()->id,
        //             "status_id" => BidStatus::firstOrCreate(["title" => ConstantsBidStatus::PENDING])->id,
        //             "commession" => $this->GetCommission($request->input("budget"), $project->category_id),
        //             "discount_id" => $request->input("discount_id")
        //         ]);

        //         $allCommissions = Commissions::all();
        //         foreach ($allCommissions as $commission) {
        //             if ($commission->category_id != null) {
        //                 if ($project->category_id != null &&  $commission->category_id == $project->category_id) {
        //                     BidCommission::create(["bid_id" => $bid->id, "commission_id" => $commission->id, "amount" => $commission->price]);
        //                 }
        //             } else {
        //                 BidCommission::create(["bid_id" => $bid->id, "commission_id" => $commission->id, "amount" => $commission->price]);
        //             }
        //         }
        //         //attachments
        //         $attached = $request->file("attach");
        //         if ($attached != null) {
        //             $destinationPath = '/uploads/projects/' . $project->id . "/bids/" . $bid->id;
        //             Utility::PathCreate($destinationPath);
        //             foreach ($attached as $attach) {
        //                 $filename = $attach->getClientOriginalName();
        //                 $attach->move(public_path($destinationPath), $filename);
        //                 BidAttachements::create([
        //                     "bid_id" => $bid->id,
        //                     "attachment" => $destinationPath . '/' . $filename,
        //                 ]);
        //             }
        //         }
        //         return $bid->id;
        //     });
        //     $project->owner()->notify(new FreelancerApplied(auth("web")->user(), $id));
        // } catch (Exception $exc) {
        //     return back()->with("error", $exc->getMessage());
        // }
        return back()->with("success", _i("You have applied to the project successfully."));
    }
}
