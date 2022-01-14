<?php

namespace App\Http\Controllers\Master\Projects;


use App\Http\Controllers\Controller;
use App\Models\Projects\ProjectBids;
use App\Models\Projects\ProjectHistory;
use App\Models\Projects\Projects;
use App\Models\SiteSettings\Messages;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Projects::select("*");
            if ((request()->input("draw")) == "1")
                $query = $query->orderByDesc('id');
            //$query = Projects::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)
                ->editColumn('created', function ($query) {
                    return $query->created = Carbon::parse($query->created_at)->diffforhumans();
                })
                ->editColumn('status_id', function ($query) {
                    if ($query->status_id != null) {
                        $status = $query->Status()->first();
                        return  '<i class="badge badge-' . $status->code . '">' . $status->title . '</i>';
                    }
                })->editColumn("title", function ($query) {
                    return "<a href='" . route("master.projects.show", ["id" => $query->id]) . "'>" . $query->title . "</a>";
                })
                ->editcolumn("owner_id", function ($query) {
                    $img = asset('/uploads/users/user-default2.jpg');
                    if ($query->owner_id != null && $query->owner()->image != null)
                        $img = $query->owner()->image;
                    return '<img src="' . $img . '" alt="' . $query->owner()->name .  '"height="50" width="50"/>';
                })
                ->addColumn('options', function ($query) {

                    $html = '
                    <a href ="' . route('master.projects.edit', $query->id) . '" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '" >
							<i class="fa fa-edit"></i> </a>  &nbsp;' . '
                    	<form class="delete" action="' . route("master.projects.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns([
                    'created',
                    'status_id',
                    "title",
                    'options',
                    'owner_id'
                ])
                ->make(true);
        }
        return view('master.projects.projects.index');
    }

    public function edit($id)
    {
        $project = Projects::findOrFail($id);

        return view('master.projects.projects.edit', compact('project'));
    }
    protected function showBid($id)
    {
        $bid = ProjectBids::find($id);
        if ($bid == null)
            abort(404, "Bid Not Found");

        $project = $bid->Project();
        $freelancer = $bid->freelancer_id;
        $history = Messages::where("project_id", $project->id)->where(function ($q) use ($freelancer) {
            return $q->where("from_user", $freelancer)->orWhere("to_user", $freelancer);
        })->latest()->get();
        return view("master.projects.projects.show", compact("bid", "project", "history"));
    }
    protected function show($id)
    {
        $project = Projects::find($id);
        $trans = $project->Transactions()->get();

        if (count($trans) == 1 || count($trans) == 0) {
            $bid = null;
            $history = null;
            if (count($trans) > 0) {
                $bid = $trans[0]->Bid()->first();

                $freelancer = $bid->freelancer_id;
                $history = Messages::where("project_id", $project->id)->where(function ($q) use ($freelancer) {
                    return $q->where("from_user", $freelancer)->orWhere("to_user", $freelancer);
                })->latest()->get();
            }


            return view("master.projects.projects.show", compact("bid", "project", "history"));
        }
        //more than one bid for same project assigned
        else {
            return view("master.projects.projects.bids", ["bids" => $trans, "project" => $project]);
        }
    }

    public function destroy($id)
    {
        $query = Projects::destroy($id);
        return response(["data" => true]);
    }
}
