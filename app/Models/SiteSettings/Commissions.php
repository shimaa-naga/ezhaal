<?php


namespace App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;

class Commissions extends Model
{
    protected $table = 'commissions';
    protected $fillable = ['title', 'type', 'price', 'code', 'category_id'];
    public $timestamps = true;
}
