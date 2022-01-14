<?php


namespace App\Http\Controllers\Master\SiteSettings;

use App\Help\Constants\DiscountModule;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\Discounts\Discount;
use App\Models\Discounts\DiscountDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Discount::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)
                ->editColumn('created_at', function ($query) {
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->editColumn('price', function ($query) {
                    return $query->type == "perc" ? $query->price . "%" : "-" . $query->price;
                })
                ->editColumn('module', function ($query) {
                    switch ($query->module) {
                        case DiscountModule::PER_DATE:
                            return "Duration";
                        case DiscountModule::PER_USER_OPERATIONS:
                            # code...
                            return "Operations/User";
                        case  DiscountModule::PER_USERS:
                            return "Users";
                        case  DiscountModule::SPECIFIC_USER:
                            return "For User";
                    }
                })
                ->editColumn('enabled', function ($query) {
                    $checked = ($query->enabled) ? "checked" : "";

                    return '<label class="switch"><input name="status" onclick="enable(this,' . $query->id . ')" type="checkbox" ' . $checked . '><span class="slider round"></span>
                  </label>';

                    // if ($query->enabled == 0) {
                    //     return  '<a href="javascript:enable('.$query->id.')" class="btn btn-round btn-xs btn-default"> ' . _i('Disabled') . '</a>';
                    // } else {
                    //     return  '<a href="javascript:enable('.$query->id.')" class="btn btn-round btn-xs btn-success"> ' . _i('Enabled') . '</a>';
                    // }
                })
                ->addColumn('options', function ($query) {
                    $query_details = DiscountDetails::where('discount_id', $query->id)->first();

                    $html = '
                        <a href ="' . route("discounts.edit", $query->id) . '" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '">
							<i class="fa fa-edit"></i>
						</a> ';

                    $html .= '
                    	 &nbsp; <form class="delete" action="' . route("discounts.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    return $html;
                })
                ->rawColumns([
                    'options',
                    'enabled',
                ])
                ->make(true);
        }
        return view('master.discount.index');
    }
    protected function enable($id)
    {
        $request = request();
        $find = Discount::find($id);
        $bol = filter_var($request->input("status"), FILTER_VALIDATE_BOOLEAN);
        $find->enabled = $bol;
        $find->save();
        return response()->json("SUCCESS");
    }
    protected function create()
    {
        return view("master.discount.create");
    }
    protected function store(Request $request)
    {
        //   dd($request->all());
        switch ($request->input("frm")) {
            case "user":
                DB::transaction(function () use ($request) {
                    $discount = Discount::create([
                        'title' => _i("User Discount"),
                        'type' => $request->type,
                        'price' => $request->price,
                        'enabled' => 1,
                        'module' => DiscountModule::SPECIFIC_USER,
                        "user_type" => "freelancer"
                    ]);
                    $discount->Users()->attach($request->input("user"));
                    DiscountDetails::create([
                        'discount_id' => $discount->id,
                        'times' => $request->times,
                        'counter' => $request->times,
                    ]);
                });

                break;
            case "duration":
                $validated = $request->validate([
                    'title' => 'required|max:255',
                    'to_date' => 'gte:from_date',
                ]);

                DB::transaction(function () use ($request) {
                    $discount = Discount::create([
                        'title' => $request->title,
                        'type' => $request->type,
                        'price' => $request->price,
                        'enabled' => $request->enabled ?? 0,
                        'module' => DiscountModule::PER_DATE,
                        "user_type" => $request->user_type
                    ]);
                    $discount->Users()->attach($request->input("selectedusers"));
                    DiscountDetails::create([
                        'discount_id' => $discount->id,
                        'from_date' => Carbon::parse($request->from_date)->format("Y-m-d"),
                        'to_date' => Carbon::parse($request->to_date)->format("Y-m-d"),
                    ]);
                });

                break;
            case "counter":
                DB::transaction(function () use ($request) {
                    $discount = Discount::create([
                        'title' => $request->title,
                        'type' => $request->type,
                        'price' => $request->price,
                        'enabled' => $request->enabled ?? 0,
                        'module' => $request->discountfor,
                        "user_type" => $request->user_type
                    ]);
                    $discount->Users()->attach($request->input("selectedusers"));
                    DiscountDetails::create([
                        'discount_id' => $discount->id,
                        'counter' => $request->counter,
                        'times' => $request->counter,
                    ]);
                });
                break;
        }

        return redirect()->back()->with("success", "Saved Successfully");
    }
    protected function edit($id)
    {
        $discount = Discount::find($id);
        if ($discount == null)
            abort(404);


        return view("master.discount.edit", compact("discount", "id"));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $discount = Discount::findOrFail($id);

        switch ($request->input("frm")) {
            case "user":
                DB::transaction(function () use ($request, $discount) {
                    $discount->update([
                        'type' => $request->type,
                        'price' => $request->price,
                    ]);
                    $discount->Users()->sync($request->input("user"));
                    $details = $discount->Details()->first();
                    $details->update([
                        'times' => $request->times,
                        'counter' => $request->times,
                    ]);
                });
                break;
            case "duration":
                $validator = Validator::make($request->all(), [
                    'title' =>  [
                        'required', 'max:50', Rule::unique('discounts')->ignore($discount->id)
                    ],
                    "to_date" => "gte:from_date"
                ]);
                DB::transaction(function () use ($request, $discount) {
                    $discount->update([
                        'title' => $request->title,
                        'type' => $request->type,
                        'price' => $request->price,
                        'enabled' => $request->enabled,
                        "user_type" => $request->user_type
                    ]);
                    $discount->Users()->sync($request->input("selectedusers"));
                    $details = $discount->Details()->first();
                    // dd(Carbon::parse($request->from_date)->format("Y-m-d"),Carbon::parse($request->to_date)->format("Y-m-d"),);
                    $details->update([
                        'from_date' => Carbon::parse($request->from_date)->format("Y-m-d"),
                        'to_date' => Carbon::parse($request->to_date)->format("Y-m-d"),
                    ]);
                });

                break;
            case "counter":
                DB::transaction(function () use ($request, $discount) {
                    $discount->update([
                        'title' => $request->title,
                        'type' => $request->type,
                        'price' => $request->price,
                        'enabled' => $request->enabled ?? 0,
                        'module' => $request->discountfor,
                        "user_type" => $request->user_type
                    ]);
                    $discount->Users()->sync($request->input("selectedusers"));
                    $details = $discount->Details()->first();
                    $details->update([
                        'counter' => $request->counter,
                        'times' => $request->counter,
                    ]);
                });
                break;
        }
        return redirect()->back()->with("success", "Updated Successfully");
    }

    public function destroy($id)
    {
        $query = Discount::destroy($id);
        return response(["data" => true]);
    }
}
