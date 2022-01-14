<?php


namespace App\Models\Projects;

use App\Models\Skills\Skills;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'projects';
    protected $fillable = ['title', 'description', 'owner_id', 'status_id', 'bid_id', 'budget', "max_budget", 'duration', 'created', "contact", "type", "expiry"];
    public $timestamps = true;
    public function ByUser()
    {
        return $this->hasOne(User::class, "id", "owner_id");
    }
    public function Category()
    {
        return $this->belongsToMany(ProjCategories::class, "project_category", "project_id", "category_id");
    }
    public function Skills()
    {
        return $this->belongsToMany(Skills::class, "project_skills", "project_id", "skill_id");
    }
    public function Status()
    {
        return $this->belongsTo(ProjStatus::class, "status_id", "id");
    }
    public function History()
    {
        return $this->hasMany(ProjectHistory::class,  "project_id", "id");
    }
    public function Transactions()
    {
        return $this->History()->whereNotNull("transaction_id");
    }
    public function getPriceTypeTitleAttribute()
    {
        if ($this->budget != null && $this->max_budget != null) {
            return _i("Range");
        } elseif ($this->budget != null) {
            return _i("More than");
        } elseif ($this->max_budget != null) {
            return _i("Less than");
        } else {
            return _i("Unspecified");
        }
    }
    public function getPriceTypeAttribute()
    {
        if ($this->budget != null && $this->max_budget != null) {
            return "range";
        } elseif ($this->budget != null) {
            return "more";
        } elseif ($this->max_budget != null) {
            return "less";
        } else {
            return "un";
        }
    }
    public function getPriceAttribute()
    {
        if ($this->budget != null && $this->max_budget != null) {
            return $this->budget . "-" . $this->max_budget;
        } elseif ($this->budget != null) {
            return $this->budget;
        } elseif ($this->max_budget != null) {
            return $this->max_budget;
        } else {
            return "";
        }
    }
    public function getExpiryDateAttribute()
    {
        $date = \Carbon\Carbon::parse($this->expiry);
        return $date->format('Y-m-d');
    }
    public function getExpiryTimeAttribute()
    {
        $date = \Carbon\Carbon::parse($this->expiry);
        return $date->format('H:i');
    }

    public function Attributes()
    {
        return $this->belongsToMany(ProjcategoryAttributes::class, "project_attributes", "project_id", "attribute_id")->where("module", $this->type);
    }
    public function Attributes2()
    {
        return $this->belongsToMany(ProjcategoryAttributes2::class, "project_attributes2", "project_id", "attribute_id")->where("module", $this->type);
    }
    public function StatusLog()
    {
        return $this->belongsToMany(ProjStatus::class, "project_history", "project_id", "status_id");
    }
    public function SelectedValue()
    {
        return $this->Attributes()->withPivot('value');
    }
    public function Attachments()
    {
        return $this->hasMany(ProjectAttachments::class, "project_id");
    }
    public function Bid()
    {
        return $this->hasOne(ProjectBids::class, "id", "bid_id");
    }
    public function bids()
    {
        return $this->hasMany(ProjectBids::class, "project_id");
    }
    public function freelancers()
    {
        return $this->hasMany(User::class, "freelancer_id");
    }
    public function owner()
    {
        return $this->hasOne(User::class, "id", "owner_id")->first();
    }
    public function StateCreated()
    {
        return $this->StatusLog()->withPivot('created_at');
    }
}
