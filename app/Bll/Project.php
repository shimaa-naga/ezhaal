<?php

namespace App\Bll;

use App\Help\Constants\ProjectStatus;
use App\Models\Projects\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Help\Utility;
use App\Models\Projects\ProjcategoryAttributes;
use App\Models\Projects\ProjectAttachments;
use App\Models\Projects\ProjectAttributes;

use App\Models\Projects\ProjStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class Project
{
    /**
     * Created Project
     * @var \App\Models\Projects\Projects
     */
    public $created;
    private function addAtrr($id, $project_id, $type, $val, $request)
    {
        if ($type == "doc" || $type == "image") {
            $attached = $request->file("attr");
            $attached = $attached[$id];
            //   dd($attached);

            if ($attached != null) {
                $destinationPath = '/uploads/projects/' . $project_id;
                Utility::PathCreate($destinationPath);

                //  foreach ($attached as $attach) {
                $filename = $attached->getClientOriginalName();
                $attached->move(public_path($destinationPath), $filename);

                $val = $destinationPath . '/' . $filename;

                //}
            }
        }

        ProjectAttributes::create(["project_id" => $project_id, "attribute_id" => $id, "value" => $val]);
    }
    private function validate($request)
    {

        //dd($request->all());
        $time = $request->input("expiry_time");
        $attr_validate = [
            "parent_category" => "required_if:category,null",
            "expiry_date" => [
                "required",
                "after_or_equal:today",
                function ($attribute, $value, $fail) use ($time) {
                    $full_date = $value . " " . $time;
                    $date1 = Carbon::createFromFormat('Y-m-d H:i', $full_date);
                    $date2 = Carbon::now()->subDay();
                    //  dd($date1->diffInHours($date2));
                    if ($date1->diffInHours($date2) < 24) {
                        $fail(_i('Expire date should be after today withen at least 24 hours.'));
                    }
                },
            ]
        ];
        //dd(request()->all());
        if ($request->price_type == "more") {
            $attr_validate["min_price"] = "required";
        } else if ($request->price_type == "less") {
            $attr_validate["_price"] = "required";
        } else if ($request->price_type == "range") {

            $attr_validate["max_price"] = "sometimes|gt:budget";
        }

        ($request->validate($attr_validate));
    }
    public  function create(Request $request, $user_id)
    {

        $this->validate($request);

        $category = null;
        if ($request->category == null)
            $category = ($request->parent_category);
        else
            $category = ($request->category);


        // foreach ($attributes as $item) {
        //     if ($item->required == 1)
        //         $attr_validate["attr[" . $item->id . "]"] = "required";
        // }

        // $validator = Validator::make($request->all(),
        //     $attr_validate
        // );

        // if ($validator->fails()) {
        //    // dd(0);
        // 	return false;
        // }
        $attributes = ProjcategoryAttributes::where("category_id", $category);
        $attributes = $attributes->where("module", $request->input("type"))->get();

        $arr_attr = $attributes->toArray();
        $attributes = array_combine(array_column($arr_attr, "id"), $arr_attr);

        $required = array_combine(array_column($arr_attr, "id"), array_pluck($arr_attr, "required"));

        $title = "New Project";
        if (count($required) > 0) {
            $id = (array_key_first($required));
            if (array_key_exists($id, $request->attr))
                if (!is_array($request->attr[$id]))
                    $title = $request->attr[$id];
        }
        try {
            //dd($request->all());
            DB::transaction(function () use ($request, $user_id, $category, $attributes, $title) {
                $attr_save = [
                    "title" => $title,
                    "description" => $request->input("desc"),
                    "duration" => $request->input("duration"),
                    "budget" => $request->input("budget"), //? $request->input("budget") : $request->input("_price") ,
                    "max_budget" => $request->input("max_price"),
                    "owner_id" => $user_id,
                    "status_id" => ProjStatus::firstOrCreate(["title" => ProjectStatus::PUBLISHED])->id,
                    "type" => $request->input("type"),
                    "expiry" => $request->input("expiry_date") . " " . $request->input("expiry_time"),
                ];
                if ($request->input("price_type") == "less") {
                    $attr_save["max_budget"] = $request->input("_price");
                } elseif ($request->input("price_type") == "more") {
                    $attr_save["budget"] = $request->input("min_price");
                }
                //   dd($attr_save);
                //project
                $project =  Projects::create($attr_save);
                //category
                $project->Category()->attach($category);
                //skills
                $project->Skills()->attach($request->skills);

                $this->created = $project;
                //attributes

                if ($request->attr != null) {

                    foreach ($request->attr as $id => $arr_val) {
                        //  $attr = ProjcategoryAttributes::find($id);
                        $attr = $attributes[$id];

                        if (is_array($arr_val)) {
                            // if (is_array($arr_val) && $attr->type == "range") {

                            //     $val = implode(",", $arr_val);
                            //     ProjectAttributes::create(["project_id" => $project->id, "attribute_id" => $id, "value" => $val]);
                            // } else

                            foreach ($arr_val as $k => $val) {
                                if ($val != null)
                                    $this->addAtrr($id, $project->id, $attr["type"], $val, $request);
                            }
                        } else {
                            if ($arr_val != null)
                                $this->addAtrr($id, $project->id, $attr["type"], $arr_val, $request);
                        }
                    }
                }

                //attachments
                $attached = $request->file("attach");
                if ($attached != null) {
                    $destinationPath = '/uploads/projects/' . $project->id;
                    Utility::PathCreate($destinationPath);

                    foreach ($attached as $attach) {
                        $filename = $attach->getClientOriginalName();
                        $attach->move(public_path($destinationPath), $filename);
                        ProjectAttachments::create([
                            "project_id" => $project->id,
                            "file" => $destinationPath . '/' . $filename,
                            "type" => $attach->getClientMimeType()
                        ]);
                    }
                }
            });
        } catch (Exception $exc) {
            error_log($exc->getMessage());
            dd($exc);
            return false;
        }
        return true;
    }
    public function update(Request $request, $id)
    {

        $this->validate($request);


        try {
            DB::transaction(function () use ($id) {
                $request = request();
                //project
                $project = Projects::where("id", $id)->where("owner_id", auth("web")->user()->id)->first();
                if ($project == null)
                    abort(404);
                $attr_save = [
                    //"title" => $title,
                    "description" => $request->input("desc"),
                    "duration" => $request->input("duration"),
                    "budget" => $request->input("budget"),
                    "max_budget" => $request->input("max_price"),
                    "expiry" => $request->input("expiry_date") . " " . $request->input("expiry_time"),
                ];
                if ($request->input("price_type") == "less") {
                    $attr_save["max_budget"] = $request->input("max_price");
                } elseif ($request->input("price_type") == "more") {
                    $attr_save["budget"] = $request->input("min_price");
                }
                $project->update($attr_save);
                //category
                $project->Category()->sync($request->category);

                $category = null;
                if ($request->category == null)
                    $category = ($request->parent_category);
                else
                    $category = ($request->category);
                $attributes = ProjcategoryAttributes::where("category_id", $category);
                $attributes = $attributes->where("module", $project->type)->get();

                $arr_attr = $attributes->toArray();
                $attributes = array_combine(array_column($arr_attr, "id"), $arr_attr);

                $required = array_combine(array_column($arr_attr, "id"), array_pluck($arr_attr, "required"));

                if ($request->attr != null) {
                    ProjectAttributes::where("project_id", $project->id)->delete();

                    foreach ($request->attr as $id => $arr_val) {
                        //  $attr = ProjcategoryAttributes::find($id);
                        $attr = $attributes[$id];

                        if (is_array($arr_val)) {
                            // if (is_array($arr_val) && $attr->type == "range") {

                            //     $val = implode(",", $arr_val);
                            //     ProjectAttributes::create(["project_id" => $project->id, "attribute_id" => $id, "value" => $val]);
                            // } else

                            foreach ($arr_val as $k => $val) {
                                if ($val != null)
                                    $this->addAtrr($id, $project->id, $attr["type"], $val, $request);
                            }
                        } else {
                            if ($arr_val != null)
                                $this->addAtrr($id, $project->id, $attr["type"], $arr_val, $request);
                        }
                    }
                }

                //attributes
                // if ($request->attr != null) {
                //     ProjectAttributes::where("project_id", $project->id)->delete();
                //     foreach ($request->attr as $id => $arr_val) {
                //         if (is_array($arr_val)) {
                //             foreach ($arr_val as $k => $val) {
                //                 //echo $val;
                //                 if ($val != null)
                //                     ProjectAttributes::create(["project_id" => $project->id, "attribute_id" => $id, "value" => $val]);
                //             }
                //         } else {
                //             if ($arr_val != null)
                //                 ProjectAttributes::create(["project_id" => $project->id, "attribute_id" => $id, "value" => $arr_val]);
                //         }
                //     }
                // }
                //attachments
                // $attached = $request->file("attach");
                // if ($attached != null) {
                //     $destinationPath = '/uploads/projects/' . $project->id;
                //     if (file_exists(public_path($destinationPath)) === false)
                //         mkdir(public_path($destinationPath));
                //     foreach ($attached as $attach) {
                //         $filename = $attach->getClientOriginalName();
                //         $attach->move(public_path($destinationPath), $filename);
                //         ProjectAttachments::create([
                //             "project_id" => $project->id,
                //             "file" => $destinationPath . '/' . $filename,
                //             "type" => $attach->getClientMimeType()
                //         ]);
                //     }
                // }
            });
        } catch (Exception $exc) {

            error_log($exc->getMessage());
            dd($exc);
            return false;
        }
    }
}
