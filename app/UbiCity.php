<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UbiCity extends Model
{
    //
    protected $table = 'pc_cities';
    public $timestamps = false;

    public function pc_districs() {
        return $this->hasMany('App\UbiDistrict', 'pc_cities_id');
    }
}
