<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    protected $table="event";
    protected $fillable = ['user_id','event_name','start','end'];
}
