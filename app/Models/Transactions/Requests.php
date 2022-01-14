<?php

namespace App\Models\Transactions;
use App\Models\Projects\ProjectBids;
use App\Models\Projects\Projects;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    protected $table = 'transaction_requests';
    protected $fillable = ['freelancer_id',"project_id","bid_id","price","note"];
    public $timestamps = true;
    public function Bid()
    {
        return $this->hasOne(ProjectBids::class,  "id", "bid_id");
    }
    public function Transaction()
    {
        return $this->join("project_history","project_history.bid_id","transaction_requests.bid_id")->whereNotNull("transaction_id")->first();
    }

    public function Project()
    {
        return $this->hasOne(Projects::class,  "id", "project_id");
    }

    public function Freelancer()
    {
        return $this->hasOne(User::class, "id", "freelancer_id");
    }
}
