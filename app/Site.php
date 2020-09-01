<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //
    protected $table = 'pc_sites';
    // public $timestamps = false;
    const CREATED_AT = 'date_add';
    const UPDATED_AT = 'date_upd';

    protected $fillable = [
        'name', 'description', 'logo', 'subdomain', 'domain', 'us_users_id', 'pc_sales_packages_id', 'user_add', 'user_upd'
    ];

    /**
     * One to Many with sites_locations
     *
     *
     */
    public function sites_locations() {
        return $this->hasMany('App\Location', 'pc_sites_id');
    }

    /**
     * One to Many with sites_lg
     *
     *
     */
    public function sites_lg() {
        return $this->hasMany('App\SiteLg', 'pc_sites_id');
    }

    /**
     * One to Many with galery, pc_galery
     *
     * @return void
     */
    public function galery() {
        return $this->hasMany('App\Galery', 'pc_sites_id');
    }

    /**
     * Many to Many with sites_categories
     *
     *
     */
    public function sites_categories() {
        return $this->belongsToMany('App\Category', 'pc_sites_categories', 'pc_sites_id', 'pc_categories_id');
    }

    /**
     * Many to Many with sites_subcategories
     *
     *
     */
    public function sites_subcategories() {
        return $this->belongsToMany('App\SubCategory', 'pc_sites_subcategories', 'pc_sites_id', 'pc_subcategories_id');
    }

    /**
     * Many to Many with sites_payment_methods
     *
     *
     */
    public function sites_payment_methods() {
        return $this->belongsToMany('App\PaymentMethod', 'pc_sites_payment_methods', 'pc_sites_id', 'pc_payment_methods_id');
    }

}
