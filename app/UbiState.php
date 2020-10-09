<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UbiState extends Model
{
    //
    protected $table = 'pc_states';
    public $timestamps = false;

    public function pc_cities() {
        return $this->hasMany('App\UbiCity', 'pc_states_id');
    }
}
