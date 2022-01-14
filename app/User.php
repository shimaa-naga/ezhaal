<?php

namespace App;

use App\Help\Constants\UserType;
use App\Help\Utility;
use App\Models\Companies;
use App\Models\Projects\ProjectBids;
use App\Models\Projects\Projects;
use App\Models\SiteSettings\CityData;
use App\Models\SiteSettings\CountryData;
use App\Models\UserInfo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use stdClass;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'web';
    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'last_name', 'user_name', 'gender', 'mobile', 'account_type', 'guard', 'is_active', 'image',
        'dob', 'balance', 'country_id', 'city_id', 'providers', 'provider_id'
    ];
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)->where($this->getTable() . '.guard', "web");

    }
    public function Company()
    {
        return $this->belongsTo(Companies::class,"id", "user_id");
    }
    public function getCompanyAttribute()
    {
        return $this->Company()->first();
    }
    public function getProfilePhotoAttribute()
    {
        return $this->image == '' ? asset('uploads/users/user-default2.jpg') : asset($this->image);
    }
    public function bids()
    {
        return $this->hasMany(ProjectBids::class, "user_id");
    }
    public function projects()
    {
        return $this->hasMany(Projects::class, "user_id");
    }
    public function info()
    {
        return $this->hasOne(UserInfo::class, "user_id");
    }

    public function countryData()
    {
        return $this->hasOne(CountryData::class, "country_id", "country_id");
    }
    public function country()
    {
        return $this->countryData()->where("lang_id", Utility::websiteLang())->first();
    }

    public function cityData()
    {
        return $this->hasOne(CityData::class, "city_id", "city_id");
    }
    public function getNameWithEmailAttribute()
    {
        return $this->name . " " . $this->email;
    }
    public function city()
    {
        return $this->cityData()->where("lang_id", Utility::websiteLang())->first();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
