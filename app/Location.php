<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $table = 'pc_sites_locations';
    // public $timestamps = false;
    const CREATED_AT = 'date_add';
    const UPDATED_AT = 'date_upd';

    protected $fillable = [
        'pc_countries_id', 'pc_states_id', 'pc_cities_id', 'pc_districs_id', 'main', 'lat', 'lng', 'address', 'status', 'phone'
    ];

}
