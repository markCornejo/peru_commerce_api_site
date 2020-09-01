<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPackageLg extends Model
{
    //
    protected $table = 'pc_sales_packages_lg';
    protected $primaryKey = 'pc_sales_packages_id';
    public $timestamps = false;

    protected $fillable = [
        'title', 'information', 'language'
    ];

}
