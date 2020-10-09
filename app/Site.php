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


    /* ************************************************************************************************************************************/
    /* *********************************************************** SCOPE ******************************************************************/
    /* ************************************************************************************************************************************/

    public function scopeGetGalerySite($query, $site_id, $skip_image, $take_image) {
        return $query->findOrFail($site_id)->galery()->orderBy('id', 'desc')->skip($skip_image)->take($take_image)->get()->map(function ($ga) {
            // $arr = preg_match_all ('/\S+\.(?:jpg|jpeg|gif|png)/', $ga->name, NULL);
            $ext = explode('.', $ga->name);
            if(@end($ext) !== "gif") {
                $ga->dataURL = config('services.image.image_url').'images/450/'.$ga->name;
                $ga->dataURLx700 = config('services.image.image_url').'images/700/'.$ga->name;
                $ga->dataURLx300 = config('services.image.image_url').'images/300/'.$ga->name;
                $ga->thumbnailUrl = config('services.image.image_url').'images/160/'.$ga->name;
            } else {
                $ga->dataURL = config('services.image.image_url').'images/'.$ga->name;
                $ga->thumbnailUrl = config('services.image.image_url').'images/'.$ga->name;
            }
            $ga->typeimage = strtoupper(end($ext));
            return $ga;
        })/*->sortBy('id')*/;
    }

}
