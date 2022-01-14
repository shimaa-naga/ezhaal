<?php


namespace App\Models\Transactions;

use App\Models\Discounts\Discount;
use App\Models\Projects\ProjectHistory as ProjectHistoryModel;
use App\Models\Projects\ProjectBids;
use App\Models\Projects\Projects;
use App\Models\SiteSettings\Commissions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['user_id', 'method_id', 'discount_id', 'total', 'currency', 'type', 'operation', 'trans_number', 'confirm_number', 'status',"commission","user_amount"];
    public $timestamps = true;
    public function Bid()
    {
        return $this->belongsToMany(ProjectBids::class, "project_history", "transaction_id", "bid_id");
    }
    public function Commisions()
    {
        return $this->belongsToMany(Commissions::class, "transaction_commission", "transaction_id", "commission_id");
    }
    public function Project()
    {
        return $this->belongsToMany(Projects::class, "project_history", "transaction_id", "project_id");
    }
    public function History()
    {
        return $this->hasMany(ProjectHistoryModel::class,  "transaction_id","id");
    }
    public function Method()
    {
        return $this->hasOne(TransactionMethod::class,  "id","method_id");
    }
    public function Discount()
    {
        return $this->hasOne(Discount::class,  "id","discount_id");
    }
    public function GetAccepted()
    {
        return $this->History()->where("status_id", function($q){
            $q->select("id")->from("proj_status")->where("title",\App\Help\Constants\ProjectStatus::ACCEPTBID);
        })->first();
    }
    public function User()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
