<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UbiCountry extends Model
{
    //
    protected $table = 'pc_countries';
    public $timestamps = false;

    public function pc_states() {
        return $this->hasMany('App\UbiState', 'pc_countries_id');
    }

}
