<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = array('first_name', 'last_name', 'email', 'phone', 'client_id');
}
