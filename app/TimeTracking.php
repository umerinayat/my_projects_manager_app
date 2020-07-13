<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeTracking extends Model
{
    //
    protected $fillable = array('is_time_started','start_time', 'end_time', 'total_time_spent', 'notes','project_id');
}
