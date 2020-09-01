<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    //
    protected $table = 'pc_galery';
    // public $timestamps = false;
    const CREATED_AT = 'date_add';
    const UPDATED_AT = 'date_upd';

    protected $fillable = [
        'pc_sites_id', 'name', 'type', 'status', 'user_add', 'user_upd', 'date_del', 'user_del'
    ];
}
