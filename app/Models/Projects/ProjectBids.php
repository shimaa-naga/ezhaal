<?php
namespace App\Models\Projects;

use App\Models\Discounts\Discount;
use App\User;
use Illuminate\Database\Eloquent\Model;
class ProjectBids extends Model
{
    protected $table = 'project_bids';
    protected $fillable = ['freelancer_id', 'project_id', 'status_id', 'payment_status', 'description',
         'price', 'commession', 'duration',"discount_id"];
    public $timestamps = true;

    public function Project()
    {
        return $this->hasOne(Projects::class,"id","project_id")->first();
    }
    public function Discount()
    {
        return $this->hasOne(Discount::class,"id","discount_id")->first();
    }
    public function Work()
    {
        return $this->hasMany(Works::class,"bid_id");
    }
    public function Freelancer()
    {
        return $this->hasOne(User::class,"id","freelancer_id")->first();
    }
    public function getFreelancerImageAttribute()
    {
        $find = $this->Freelancer();
        if ($find != null)
        {
            return $find->image == '' ?  asset('uploads/users/user-default2.jpg') : asset($find->image);

        }
        return "";
    }
    public function Status()
    {
        return $this->hasOne(BidStatus::class,"id","status_id")->first();
    }
    public function getStatusAttribute()
    {
        $state =($this->Status());
        if($state!=null)
            return $state->title;
        return "";
    }
    public function getStatusCodeAttribute()
    {
        $state =($this->Status());
        if($state!=null)
            return $state->code;
        return "";
    }
    public function getPriceAfterAttribute()
    {
        return ($this->price -$this->commession) ;
    }
    public function Attachments()
    {
        return $this->hasMany(BidAttachements::class,"bid_id");
    }
    public function Commissions()
    {
        return $this->hasMany(BidCommission::class,"bid_id");
    }

}
