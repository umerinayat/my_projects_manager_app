<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = array('project_name', 'project_description', 'label', 'due_date', 'due_time', 'client_id');
}
