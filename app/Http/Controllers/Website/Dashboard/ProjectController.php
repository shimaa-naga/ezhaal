<?php

namespace App\Http\Controllers\Website\Dashboard;

use App\Bll\Project;
use App\Help\Category;
use App\Help\Constants\ProjectStatus;

use App\Http\Controllers\Controller;
use App\Models\Projects\ProjCategories;
use App\Models\Projects\ProjcategoryAttributes;
use App\Models\Projects\ProjectAttachments;
use App\Models\Projects\ProjectAttributes;
use App\Models\Projects\ProjectBids;

use App\Models\Projects\Projects;

use App\Models\Projects\ProjStatus;
use App\Traits\Pricing;
use Carbon\Carbon;
use Exception;
use Storage;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Help;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{

    public function getAttr($category)
    {
        if (request()->ajax()) {

            $items = ProjcategoryAttributes::where("category_id", $category)->where("module", request()->query("type"))->orderBy("sort")->get();


            $project = null;
            if (request()->input("project") != null) {
                $project = Projects::find(request("project"));
            }
            return response()->json(view("website.dashboard.project.partial.attributes", compact("items", "project"))->render(), 200);
        }
    }
    public function getCats($category)
    {
        if (request()->ajax()) {
            $result = [];
            $find = ProjCategories::where("id", $category)->first();
            if ($find != null) {
                $obj = new Category();
                $obj->without_parents = true;
                $result = $obj->getChildren($find);
            }

            // $project = null;
            // if (request()->input("project") != null) {
            //     $project = Projects::find(request("project"));
            // }
            return response()->json(["results" => $result], 200);
        }
    }
    protected function index()
    {
        if (request()->ajax()) {
            $query = Projects::select("*")->where("owner_id", auth("web")->user()->id);
            $bids = ProjectBids::whereIn("project_id", $query->get()->pluck("id", "id"))->select("project_id", "id")->get()->pluck("id", "project_id")->toArray();


            if ((request()->input("draw")) == "1")
                $query = $query->orderByDesc('id');
            return DataTables::eloquent($query)
                ->editColumn('created', function ($query) {
                    return $query->created = Carbon::parse($query->created_at)->diffforhumans();
                })
                ->addColumn('price', function ($query) {
                    return $query->price;
                })
                ->addColumn('price_type', function ($query) {
                    return $query->PriceTypeTitle;
                })
                ->editColumn('status_id', function ($query) {
                    if ($query->status_id != null) {
                        $status = $query->Status()->first();
                        if ($status->title == ProjectStatus::ASSIGNED || $status->title == ProjectStatus::CLOSED) {
                            $item = $query->History()->where("status_id", function ($q) {
                                $q->from("proj_status")->where("title", ProjectStatus::ASSIGNED)->select("id");
                            })->latest("id")->first();
                            if ($item != null)
                                return  '<a href="' . url("dash/bid/" . $item->bid_id) . '">
                            <span class="badge badge-' . $status->code . '">' . $status->title . '</span> >> </a>';
                        }
                        return  '<span class="badge badge-' . $status->code . '">' . $status->title . '</span>';
                    }
                })
                ->addColumn("title", function ($query) {
                    return '<a href="project/' . $query->id . '" class="" title="' . _i("Show") . '">' . $query->title . '</a>';
                })
                ->addColumn('options', function ($query) use ($bids) {
                    $html = "";
                    if (!array_key_exists($query->id, $bids)) {
                        $html = '<a href="project/' . $query->id . '/edit" class="btn btn-primary btn-sm" title="' . _i("Edit") . '"><i class="fa fa-edit"></i></a>';

                        $html .= '
                    	<form class="delete" action="project/' . $query->id . '"  method="Delete" id="delform" style="display: inline-block;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger btn-sm" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form>';
                    }
                    return $html;
                })
                ->rawColumns([
                    'created',
                    'title',
                    'status_id',
                    'options',
                ])
                ->make(true);
        }

        return view("website.dashboard.project.index");
    }
    protected function create()
    {
        return view("website.dashboard.project.create", ["service" => false]);
    }
    protected function createService()
    {

        return view("website.dashboard.project.create", ["service" => true]);
    }
    protected function store(Request $request)
    {

        $bll = new Project();
        if ($bll->create($request, auth("web")->user()->id)) {
            return redirect("dash/project/" . $bll->created->id . "?publish=1");
        }
        return back()->with("error", _i("An Error has been occured"))->withInput(request()->all());
    }
    protected function publish($id)
    {
        if (!is_numeric($id))
            abort(404);
        $project = Projects::where("id", $id)->where("owner_id", auth("web")->user()->id)->first();

        if ($project == null)
            abort(404);
        $status_id = ProjStatus::firstOrCreate(["title" => ProjectStatus::PUBLISHED])->id;
        $project->update([
            "status_id" => $status_id
        ]);
        // $project->StatusLog()->attach($status_id, ["by_id" => auth("web")->user()->id, "created_at" => Carbon::now()]);
        return back()->with("success", _i("Your project has been published successfully."));
    }
    protected function update($id)
    {

        if (!is_numeric($id))
            abort(404);
        try {
            // DB::transaction(function () use ($id) {
            //     $request = request();
            //     //project
            //     $project = Projects::where("id", $id)->where("owner_id", auth("web")->user()->id)->first();
            //     if ($project == null)
            //         abort(404);
            //     $project->update([
            //         "title" => $request->input("title"),
            //         "description" => $request->input("desc"),
            //         "duration" => $request->input("duration"),
            //         "budget" => $request->input("budget"),
            //         "owner_id" => auth("web")->user()->id,
            //         "status_id" => ProjStatus::firstOrCreate(["title" => ProjectStatus::OPEN])->id
            //     ]);
            //     //category
            //     $project->Category()->sync($request->category);
            //     //skills
            //     // $project->Skills()->sync($request->skills);

            //     //attributes
            //     if ($request->attr != null) {
            //         ProjectAttributes::where("project_id", $project->id)->delete();
            //         foreach ($request->attr as $id => $arr_val) {
            //             if (is_array($arr_val)) {
            //                 foreach ($arr_val as $k => $val) {
            //                     //echo $val;
            //                     if ($val != null)
            //                         ProjectAttributes::create(["project_id" => $project->id, "attribute_id" => $id, "value" => $val]);
            //                 }
            //             } else {
            //                 if ($arr_val != null)
            //                     ProjectAttributes::create(["project_id" => $project->id, "attribute_id" => $id, "value" => $arr_val]);
            //             }
            //         }
            //     }
            //     //attachments
            //     $attached = $request->file("attach");
            //     if ($attached != null) {
            //         $destinationPath = '/uploads/projects/' . $project->id;
            //         if (file_exists(public_path($destinationPath)) === false)
            //             mkdir(public_path($destinationPath));
            //         foreach ($attached as $attach) {
            //             $filename = $attach->getClientOriginalName();
            //             $attach->move(public_path($destinationPath), $filename);
            //             ProjectAttachments::create([
            //                 "project_id" => $project->id,
            //                 "file" => $destinationPath . '/' . $filename,
            //                 "type" => $attach->getClientMimeType()
            //             ]);
            //         }
            //     }
            // });
            $bll = new Project();
            $bll->update(request(), $id);
        } catch (Exception $exc) {

            return back()->with("error", $exc->getMessage());
        }

        return back()->with("success", _i("Your project has been updated successfully."));
    }
    protected function destroy($id)
    {
        Projects::where("owner_id", auth("web")->user()->id)->where("id", $id)->delete();

        return response(["data" => true]);
    }
    protected function delAttach($id)
    {
        $find = ProjectAttachments::find($id);
        if ($find != null) {
            $file = public_path($find->file);
            if (File::exists($file))
                File::delete($file);
            ProjectAttachments::destroy($id);
        }
        //
        return response(["data" => true]);
    }
    protected function show($id)
    {
        if (!is_numeric($id))
            abort(404);

        $disabled = true;
        $project = Projects::findOrFail($id);
        if ($project->Owner()->id != auth("web")->user()->id) {
            abort(401);
        }
        if ($project == null)
            abort(404);
        $service = ($project->type == "service") ? true : false;

        $limit = 10;
        $bids = ProjectBids::where("project_id", $id)->paginate($limit);
        if (request()->ajax()) {
            return view('website.dashboard.project_bids.parial.bids_actions_ajax', compact('bids'))->render();
        }
        return view("website.dashboard.project.show", compact('project', "id", "disabled", "bids"));
    }
    protected function edit($id)
    {
        if (!is_numeric($id))
            abort(404);

        $disabled = true;
        $project = Projects::findOrFail($id);
        if ($project->Owner()->id != auth("web")->user()->id) {
            abort(401);
        }
        if ($project == null)
            abort(404);
        $service = ($project->type == "service") ? true : false;

        if ($project->bids()->count() == 0 && $project->Owner()->id == auth("web")->user()->id)
            return view("website.dashboard.project.edit", compact('project', "id", "service"));

        $limit = 10;
        $bids = ProjectBids::where("project_id", $id)->paginate($limit);
        if (request()->ajax()) {
            return view('website.dashboard.project_bids.parial.bids_actions_ajax', compact('bids'))->render();
        }
        return view("website.dashboard.project.show", compact('project', "id", "disabled", "bids"));
    }
}
