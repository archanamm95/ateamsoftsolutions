<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invite extends Model
{
    protected $table="invite";
    protected $fillable = ['event_id','email'];
}
