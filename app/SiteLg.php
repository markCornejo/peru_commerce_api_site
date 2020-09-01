<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteLg extends Model
{
    //
    protected $table = 'pc_sites_lg';
    protected $primaryKey = 'pc_sites_id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'language'
    ];
}
