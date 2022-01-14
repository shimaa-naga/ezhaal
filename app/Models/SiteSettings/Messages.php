<?php


namespace App\Models\SiteSettings;
use App\Models\Projects\Projects;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';
    protected $fillable = ['from_user', 'to_user', 'message_id', 'subject', 'body','project_id','read_at'];
    public $timestamps = true;

    public function from()
    {
        return $this->hasOne(User::class,"id","from_user");
    }

    public function project()
    {
        return $this->hasOne(Projects::class,"id","project_id");
    }
    public function Previous()
    {
        return $this->hasOne(Messages::class,"id","message_id");
    }
}
