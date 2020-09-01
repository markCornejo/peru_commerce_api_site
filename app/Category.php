<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'pc_categories';
    public $timestamps = false;

    /**
     * Many to Many with pc_sites_categories
     *
     *
     */
    public function sites_categories() {
        return $this->belongsToMany('App\Site', 'pc_sites_categories', 'pc_categories_id', 'pc_sites_id');
    }

}
