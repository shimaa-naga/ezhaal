<?php

namespace App;

use Illuminate\Support\Facades\DB;

class DataTable
{
    public function __construct($elequent)
    {
        $this->elequent = $elequent;
    }
    private $columns = null;
    public function columns($cols)
    {
        $this->columns = $cols;
    }
    public function response()
    {
        $request = request();
        $limit = $request->length;
        $draw = $request->draw;
        $offset = ($request->start);
        //search[value]: pendi
        $search = $request->search;
        $search = $search["value"];
        if ($search != null)
            $this->elequent->Where(function ($q) use ($search, $request) {
                foreach ($request->columns as $column) {

                    if ($column["searchable"] != null && ($column["searchable"]) === "true") {

                        if ($this->columns != null) {
                            $result = preg_grep('~' . $column["data"] . '~', $this->columns);

                            foreach ($result as $item) {

                                //    $this->elequent->orWhere($item, "like", "%" . $search . "%");
                                $q->orWhere($item, "like", "%" . $search . "%");
                            }
                        } else {
                            $q->orWhere($column["data"], "like", "%" . $search . "%");
                        }
                    }
                }
                $q->where($column["data"], "like", "%" . $search . "%");
            });



        // if ($search != null)
        // DB::enableQueryLog(); // Enable query log

        // Your Eloquent query executed by using get()


        $total = $this->elequent->get();
        // if ($search != null)
        // dd(DB::getQueryLog()); // Show results of log

        //order[0][column]: 1
        //order[0][dir]: asc
        $arr = ($request->order)[0];
        $colIndex = $arr["column"];
        $by = $arr["dir"];
        //columns[0][data]
        $column = $request->columns[$colIndex]["data"];

        $query = $this->elequent->orderBy($column, $by)->offset($offset)->limit($limit)->get();
        $total = count($total);
        return  response()->json([
            "draw" => $draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => ($query),
        ], 200);
    }
}
