<?php


namespace App\Http\Controllers\Website;

use App\Bll\Project;
use App\Help\Constants\ProjectStatus;
use App\Bll\User;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\Projects\ProjCategories;
use App\Models\Projects\ProjCategoryData;

use App\Models\Projects\Projects;
use App\Traits\Pricing;
use Illuminate\Http\Request;


class ProjectsController extends Controller
{
    use Pricing;
    protected function index(Request $request, $filter_category = "", $title = "")
    {

        $limit = 10;
        $max = Projects::max("budget");

        $projects = Projects::leftJoin('proj_status', 'proj_status.id', 'projects.status_id')
            ->where('proj_status.title', ProjectStatus::PUBLISHED)
            ->leftJoin('project_category', 'project_category.project_id', 'projects.id')
            ->join("projcategories","projcategories.id","project_category.category_id")
            ->where("projcategories.published",1)
            ->select('projects.*');
            //->orderByDesc('projects.id');
        if (request()->input("title") != null)
            $projects = $projects->where("projects.title", "iLike", "%" . request()->input("title") . "%");
        if (request()->ajax()) {

            if ($request->category_ids) {
                $ids = $request->category_ids;
                $projects = $projects
                    ->whereIn('project_category.category_id', $request->category_ids)
                    ->orWhereIn("project_category.category_id", function ($q) use ($ids) {
                        $q->from("projcategories")->select("id")->whereIn("parent_id", $ids);
                    });
            }
            if ($request->range != null) {
                $projects = $projects->whereBetween("budget", explode("-", $request->input("range")));
            }
            if ($request->type != null) {
                $projects = $projects->where("type", $request->input("type"));
            }
            if ($request->sort != null && $request->sort != "") {
                if ($request->input("sort") == "latest") {
                    $projects = $projects->orderBy("id", "desc");

                }
                elseif ($request->input("sort") == "old") {
                    $projects = $projects->orderBy("id", "asc");
                }
                elseif ($request->input("sort") == "low-price") {
                    $projects = $projects->orderBy("budget", "asc");
                }
                elseif ($request->input("sort") == "high-price") {
                    $projects = $projects->orderBy("budget", "desc");
                }
            }

           // dd($projects->toSql());

            $projects = $projects->paginate($limit);
            return view('website.dashboard.projects.partial.projects_ajax', compact('projects'))->render();
        }
        if ($filter_category !== "") {

            $projects = $projects
                ->where('project_category.category_id', $filter_category)
                ->orWhereIn("project_category.category_id", function ($q) use ($filter_category) {
                    $q->select("id")->from("projcategories")->where("parent_id", $filter_category);
                });
        }
        $projects = $projects->paginate($limit);
        $total = $projects->total();
        $projcategory = ProjCategories::whereNull("parent_id")->where("type", "project")->where("published", "1")->get();

        $eqDiscount = $this->GetDiscountJSEquation();
        $eq = $this->GetCommissionJSEquation();
        $discount =$this->GetDiscount();
        return view('website.dashboard.projects.index', compact('projcategory', 'projects', 'filter_category', "limit", "total", "max","eqDiscount","eq","discount"));
    }
    protected function category($title)
    {
        $find = ProjCategoryData::where("title", $title)->first();
        if ($find == null)
            abort(404);
        return $this->index(request(), $find->category_id);
    }
    protected function create()
    {
        return view("website.dashboard.project.create", ["service" => false]);
    }
    protected function create_service()
    {

        return view("website.dashboard.project.create", ["service" => true]);
    }
    private function register($request)
    {
        $userBll = new User();
        if ($userBll->Register($request)) {
            $projectBll = new Project();
            if ($projectBll->create($request, $userBll->created->id)) {
                return view("website.thanks", [
                    "title" => _i("Register complete"),
                    "msg" => _i("Your account has been created successfully. please check your email to activate your account.")
                ]);
            }
            return back()->with("error", _i("Can not create user project"));
        }
        return back()->with("error", _i("Can not create user account"));
    }
    private function login($request)
    {
        $userBll = new User();
        if ($userBll->login($request, "login_email", "login_password")) {
            $projectBll = new Project();
            if ($projectBll->create($request, $userBll->created->id)) {
                if ($userBll->GetError() == "") {
                    //redirect to edit project
                    return redirect("dash/project/" . $projectBll->created->id);
                }
                return view("website.thanks", [
                    "title" => _i("Project Created"),
                    "msg" => _i("Your project has been created successfully.") . $userBll->GetError()
                ]);
            }
            return back()->withInput($request->all())->with("error", _i("Can not create user project"));
        }
        if ($userBll->GetError() != "")
            return back()->with("error", $userBll->GetError())->withInput($request->all());

        return back()->with("error", _i("Can not login to your account"))->withInput($request->all());
    }
    protected  function storeWithoutLogin(Request $request)
    {
        if ($request->input("btn") == "register") {
            return $this->register($request);
        } else {
            return $this->login($request);
        }
    }
    protected function search(Request $request)
    {
        $filter_category = (request()->input("category") == null) ? "" : request()->input("category");
        return $this->index($request, $filter_category);
    }
}
