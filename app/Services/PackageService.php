<?php

namespace App\Services;

use App\PrivilegesActionsPackage;
use App\SalesPackage;
use App\SalesPackageLg;

class PackageService
{

    /**
     * Actualizar privilegios. Se elimina privilegios y se agregan
     *
     * @param  App\SalesPackage $salesPackage
     * @param  int $sales_package_id
     * @param  array $privileges_actions_packages
     *
     */
    public function updatePrivileges(SalesPackage $salesPackage, int $sales_package_id, array $privileges_actions_packages) {
        // actualizar privilegios
        if($privigexist = PrivilegesActionsPackage::find($sales_package_id)) {
            $privigexist->delete();
        }
        if($privileges_actions_packages && count($privileges_actions_packages) > 0) {
            $response = $salesPackage->where('status', 0)->orWhere('status', 1)->findOrFail($sales_package_id)->privileges_actions_packages()->createMany($privileges_actions_packages);
        }
    }

    /**
     * Actualizar lenguaje sales package. Se elimina sales package language y se agregan
     *
     * @param  App\SalesPackage $salesPackage
     * @param  int $sales_package_id
     * @param  array $language_secondary
     *
     */
    public function updateSalesPackage(SalesPackage $salesPackage, int $sales_package_id, array $language_secondary) {
        // actualizar otro lenguaje
        if($packagexist = SalesPackageLg::find($sales_package_id)) {
            $packagexist->delete();
        }
        if($language_secondary && count($language_secondary) > 0) {
            $response = $salesPackage->where('status', 0)->orWhere('status', 1)->findOrFail($sales_package_id)->sales_packages_lg()->createMany($language_secondary);
        }
    }

}
