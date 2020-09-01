<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivilegesActionsPackage extends Model
{
    //
    protected $table = 'pc_privileges_actions_packages';
    // protected $primaryKey = ['pc_privileges_action_name', 'pc_sales_packages_id'];
    protected $primaryKey = 'pc_sales_packages_id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'pc_privileges_action_name'
    ];

}
