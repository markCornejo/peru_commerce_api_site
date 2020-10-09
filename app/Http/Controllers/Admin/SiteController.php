<?php

namespace App\Http\Controllers\Admin;

use App\Site;
use App\Traits\ApiResponser;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteAdminRequest;
use App\Http\Resources\SiteAdmin as SiteAdminResources;
use App\Location;
use App\MgUbiGeo;
use App\SiteLg;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{

    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteAdminRequest $request)
    {
        $data = $request->all();
        $site = Arr::except($data, ['locations', 'language_secondary']);
        $site['us_users_id'] = $site['users_id'];
        $site['user_add'] = $site['users_id'];
        $site['pc_sales_packages_id'] = 1; // por default inicia con version gratis

        $locations = (@$data['locations']) ? $data['locations'] : [];
        $language_secondary = (@$data['language_secondary']) ? $data['language_secondary'] : [];

        DB::transaction(function () use ($site, $locations, $language_secondary) {
            $site = Site::create($site);
            $site->sites_locations()->createMany($locations);
            $site->sites_lg()->createMany($language_secondary);
        });

        return $this->successResponse(true, []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $site_id = (int) $request->route('site');
        $site = Site::with('sites_lg')
                ->with(['sites_locations' => function($query) {
                    return $query->with(['ubicountry' => function($query) {
                                $query->select('id', 'name');
                            }])->with(['ubistate' => function($query) {
                                $query->select('id', 'name');
                            }])->with(['ubicity' => function($query) {
                                $query->select('id', 'name');
                            }])->with(['ubidistrict' => function($query) {
                                $query->select('id', 'name');
                            }]);
                }])
                ->with('sites_categories')
                ->with('sites_subcategories')
                ->findOrFail($site_id);

        return $this->successResponse(true, new SiteAdminResources($site));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site_id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteAdminRequest $request, Site $pc_site)
    {
        $site_id = (int) $request->route('site');
        $data = $request->all();
        $site = Arr::except($data, ['locations', 'language_secondary']);
        $site['user_upd'] = $site['users_id'];

        $locations = @$data['locations'];
        $language_secondary = @$data['language_secondary'];

        // actualizar package
        $pc_site->findOrFail($site_id)->fill($site)->save();

        // actualizar pc_sites_locations
        Location::where('pc_sites_id', $site_id)->delete();
        if($locations && count($locations) > 0) {
            $pc_site->findOrFail($site_id)->sites_locations()->createMany($locations);
        }

        // actualizar otro lenguaje
        if($siteexist = SiteLg::find($site_id)) {
            $siteexist->delete();
        }
        if($language_secondary && count($language_secondary) > 0) {
            $pc_site->findOrFail($site_id)->sites_lg()->createMany($language_secondary);
        }

        return $this->successResponse(true, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
    }


    public function simple(Request $request, Site $pc_site)
    {
        $site_id = $request->route('site');
        $site = $pc_site->findOrFail($site_id);
        return $this->successResponse(true, new SiteAdminResources($site));
    }

}
