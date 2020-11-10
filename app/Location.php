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
        'pc_sites_id', 'pc_countries_id', 'pc_states_id', 'pc_cities_id', 'pc_districs_id', 'main', 'lat', 'lng', 'address', 'status', 'phone'
    ];

    public function ubicountry() {
        return $this->belongsTo('App\UbiCountry', 'pc_countries_id');
    }

    public function ubistate() {
        return $this->belongsTo('App\UbiState', 'pc_states_id');
    }

    public function ubicity() {
        return $this->belongsTo('App\UbiCity', 'pc_cities_id');
    }

    public function ubidistrict() {
        return $this->belongsTo('App\UbiDistrict', 'pc_districs_id');
    }


    /* ************************************************************************************************************************************/
    /* *********************************************************** SCOPE ******************************************************************/
    /* ************************************************************************************************************************************/

    /**
     * Obtener el ultimo registro de locacion de un sitio
     *
     * @param  App/Location $query
     * @param  int $site_id
     * @return App/Location
     */
    public function scopeSiteLocations($query, $site_id) {

        return $query->where('pc_sites_id', $site_id)
                        ->with(['ubicountry' => function($query) {
                            $query->select('id', 'name');
                    }])->with(['ubistate' => function($query) {
                            $query->select('id', 'name');
                    }])->with(['ubicity' => function($query) {
                            $query->select('id', 'name');
                    }])->with(['ubidistrict' => function($query) {
                            $query->select('id', 'name');
                    }])
                    ->latest()
                    ->first();
                    ;

    }

}
