<?php

namespace App\Http\Controllers\Master;

use App\PrivilegesActionsPackage;
use App\SalesPackage;
use App\SalesPackageLg;
use App\Services\PackageService;
use App\Traits\ApiResponser;
use App\Http\Resources\SalesPackageMaster as SalesPackageMasterResources;
use App\Http\Resources\SalesPackageMasterCollection;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SalesPackageController extends Controller
{

    use ApiResponser;

    protected $_servicePackage;

    public function __construct(PackageService $servicePackage)
    {
        $this->_servicePackage = $servicePackage;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $package = SalesPackage::where('status', 0)->orWhere('status', 1)->with("sales_packages_lg")->paginate('100');
        return $this->successResponse(true, new SalesPackageMasterCollection($package));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        $sales_package = Arr::except($data, [/*'privileges_actions_packages',*/'language_secondary']);
        $sales_package['user_add'] = $sales_package['user_id']; // user_id del login
        // $privileges_actions_packages = (@$data['privileges_actions_packages']) ? $data['privileges_actions_packages'] : [];
        $language_secondary = (@$data['language_secondary']) ? $data['language_secondary'] : [];

        //verificar privilegios en el api-per-auth

        DB::transaction(function () use ($sales_package, $language_secondary) {
            $salespackage = SalesPackage::create($sales_package);
            // $salespackage->privileges_actions_packages()->createMany($privileges_actions_packages);
            $salespackage->sales_packages_lg()->createMany($language_secondary);
        });

        return $this->successResponse(true, []);
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $sales_package_id = (int) $request->route('salespackage');
        $package = SalesPackage::where('status', 0)->orWhere('status', 1)->with('sales_packages_lg')->findOrFail($sales_package_id);
        return $this->successResponse(true, new SalesPackageMasterResources($package));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesPackage  $salesPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesPackage $salesPackage)
    {
        //
        $sales_package_id = (int) $request->route('salespackage');
        $data = $request->all();
        $sales_package = Arr::except($data, [/*'privileges_actions_packages', */'language_secondary']);
        $sales_package['user_upd'] = $sales_package['user_id']; // user_id del login
        // $privileges_actions_packages = @$data['privileges_actions_packages'];
        $language_secondary = @$data['language_secondary'];

        DB::transaction(function () use ($salesPackage, $sales_package, $sales_package_id, $language_secondary) {
            // actualizar package
            $salesPackage->where('status', 0)->orWhere('status', 1)->findOrFail($sales_package_id)->fill($sales_package)->save();

            // actualizar privilegios
            // $this->_servicePackage->updatePrivileges($salesPackage, $sales_package_id, $privileges_actions_packages);

            // actualizar otro lenguaje
            $this->_servicePackage->updateSalesPackage($salesPackage, $sales_package_id, $language_secondary);
        });

        return $this->successResponse(true, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesPackage  $salesPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesPackage $salesPackage, Request $request)
    {
        //
        $sales_package_id = (int) $request->route('salespackage');
        $data = $request->all();
        DB::transaction(function () use ($salesPackage, $sales_package_id, $data) {
            $salesPackage->where('status', 0)->orWhere('status', 1)
                            ->findOrFail($sales_package_id)
                            ->fill(["status" => 2, 'user_del' => (int) $data['user_id'], 'date_del' => Carbon::now()->format('Y-m-d H:i:s')])->save();
        });
        return $this->successResponse(true, []);
    }
}
