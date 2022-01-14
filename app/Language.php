<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = ['title','code','flag'];
    public $timestamps = false;
}
