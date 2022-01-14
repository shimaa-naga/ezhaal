<?php


namespace App\Models\Projects;

use App\Models\Transactions\Transaction;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ProjectHistory extends Model
{
    protected $table = 'project_history';
    protected $fillable = ['project_id','bid_id','status_id', 'by_id',"transaction_id"];
    public $timestamps = true;
    public function Status()
    {
        return $this->belongsTo(ProjStatus::class, "status_id", "id");
    }
    public function Transaction()
    {
        return $this->hasOne(Transaction::class,"id","transaction_id");
    }
    public function Bid()
    {
        return $this->hasOne(ProjectBids::class,"id","bid_id");
    }
    public function getTitleAttribute()
    {
        $find = $this->Status()->first();
        if ($find != null)
            return $find->title;
        return "";
    }
    public function getByUserImageAttribute()
    {
        $find = $this->By()->first();
        if ($find != null)
        {
            return $find->image == '' ?  asset('uploads/users/user-default2.jpg') : asset($find->image);

        }
        return "";
    }
    public function getByUserNameAttribute()
    {
        $find = $this->By()->first();
        if ($find != null)
        {
            return $find->name;

        }
        return "";
    }
    public function By()
    {
        return $this->hasOne(User::class,"id","by_id");
    }
}
