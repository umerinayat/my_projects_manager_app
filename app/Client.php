<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = array('name', 'master_data', 'notes', 'profile_pic');
}
