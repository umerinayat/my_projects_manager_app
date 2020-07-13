<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientChosenProduct extends Model
{
    //
    protected $fillable = array('product_id', 'client_id');
}
