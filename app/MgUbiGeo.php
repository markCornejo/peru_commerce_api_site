<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Colleccion para registrar a los usuarios con roles y sus privilegios. Ayuda para hacer la consulta más rapida.
 */
class MgUbiGeo extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'mg_ubigeo';
    // const CREATED_AT = "date_add";
    // const UPDATED_AT = "date_upd";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'cod',
        'zone_time_country',
        'img_flag',
        'cod_phone',
        'cod_language',
        'lcid_language',
        'money',
        'money_name',
        'money_symbol',
        'money_code',
        'money_paypal',
        'status',
        'lat',
        'lng',
        'pc_states'
    ];

    protected $hidden = [
        "_id"
    ];


    /* ************************************************************************************************************************************/
    /* *********************************************************** SCOPE ******************************************************************/
    /* ************************************************************************************************************************************/


    /**
     * Registrar  y obtener data completa de las tablas de pais.
     *
     * @param  App/MgUbiGeo $query
     * @param  mixed $cod_country , codigo de pais PE, MX. Si cod_country = 0 entonces obtendrá toda la data de paises
     * @return json_decode | boolean false
     */
    public function scopeCacheUbigeo($query, $cod_country) {

        $result = false;

        try{

            if($query->count() > 0) {
                if($cod_country) {
                    $result = self::where('cod', $cod_country)->get();
                } else {
                    $result = self::all();
                }
            } else {
                $data = UbiCountry::with(['pc_states' => function($query) {
                    return $query->with(['pc_cities' => function($query) {
                        return $query->with(['pc_districs']);
                    }]);
                }])->get()->toArray();

                if($query->insert($data)) {
                    if($cod_country) {
                        $result = self::where('cod', $cod_country)->get();
                    } else {
                        $result = self::all();
                    }
                    $result = self::all();
                }
            }

        } catch (\Exception $e) {
            Log::error("Mongo error App\MgUbiGeo - CacheUbigeo. Problemas ".$e);
            abort(500, "Mongo error App\MgUbiGeo - CacheUbigeo. Problemas ".$e);
        }

        return $result;
    }


}
