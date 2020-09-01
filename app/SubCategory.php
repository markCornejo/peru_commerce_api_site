<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    //
    protected $table = 'pc_subcategories';
    public $timestamps = false;

    /**
     * Many to Many with pc_categories
     *
     *
     */
    public function sites_categories() {
        return $this->belongsToMany('App\Site', 'pc_sites_categories', 'pc_subcategories_id', 'pc_sites_id');
    }

}
