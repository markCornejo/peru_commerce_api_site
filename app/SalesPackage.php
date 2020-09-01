<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPackage extends Model
{
    //
    protected $table = 'pc_sales_packages';
    // public $timestamps = false;
    const CREATED_AT = 'date_add';
    const UPDATED_AT = 'date_upd';

    protected $fillable = [
        'title', 'information', 'price', 'discount', 'image', 'status', 'show', 'user_add', 'user_upd', 'user_del', 'date_del'
    ];

    /**
     * One to Many with sales_packages_lg
     *
     *
     */
    public function sales_packages_lg() {
        return $this->hasMany('App\SalesPackageLg', 'pc_sales_packages_id');
    }

    /**
     * One to Many with sales_packages_lg
     *
     *
     */
    /*
    public function privileges_actions_packages() {
        return $this->hasMany('App\PrivilegesActionsPackage', 'pc_sales_packages_id');
    }
    */

    /**
     * Many to Many with sites_payment_methods
     *
     *
     */
    /*
    public function privileges_actions_packages() {
        return $this->belongsToMany('App\PaymentMethod', 'pc_privileges_actions_packages', 'pc_sales_packages_id', 'pc_payment_methods_id');
    }
    */



}
