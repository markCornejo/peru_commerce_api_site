<?php

namespace App\Http\Controllers\Admin;

use App\Site;
use App\Traits\ApiResponser;
use App\Http\Requests\CategorySubAdminRequest;
use App\Http\Resources\CategorySubcategoryAdminCollection;
use App\Http\Resources\CategorySubcategoryAdmin as CategorySubcategoryAdminResources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategorySubcategoryController extends Controller
{

    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategorySubAdminRequest $request)
    {
        $site_id = $request->route('site');
        $cateSubcate = Site::with('sites_categories')->with('sites_subcategories')->findOrFail($site_id);
        return $this->successResponse(true, new CategorySubcategoryAdminResources($cateSubcate));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorySubAdminRequest $request)
    {
        $site_id = $request->route('site');
        $data = $request->all();
        $category = $data['category'];
        $subcategory = $data['subcategory'];

        DB::transaction(function () use ($site_id, $category, $subcategory) {

            Site::findOrFail($site_id)->sites_categories()->attach($category);
            Site::findOrFail($site_id)->sites_subcategories()->attach($subcategory);

        });

        return $this->successResponse(true, []);

    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // return $this->successResponse(true, new CategorySubcategoryAdminResources())
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
