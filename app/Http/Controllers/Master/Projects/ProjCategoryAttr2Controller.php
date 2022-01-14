<?php

namespace App\Http\Controllers\Master\Projects;

use App\Models\Projects\ProjcategoryAttributes2;
use Illuminate\Http\Request;

class ProjCategoryAttr2Controller extends MasterCategoryAttrController
{
    public function index($category, Request $request)
    {
        return $this->m_index($category, $request, true);
    }
    protected function store($category)
    {
        return $this->m_store($category, true);
    }
    protected function up($category, $id)
    {
        return $this->m_up($category, $id, true);
    }

    protected function down($category, $id)
    {
        return $this->m_down($category, $id, true);
    }

    protected function show($category, $id)
    {

        return $this->m_show($id,true);
    }
    protected function save(Request $request)
    {

        return $this->m_save($request,true);
    }
    protected function destroy($category, $id)
    {

        ProjcategoryAttributes2::destroy($id);
        return response(["data" => true]);
    }
}
