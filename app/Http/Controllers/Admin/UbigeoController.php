<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\UbigeoAdminRequest;
use App\MgUbiGeo;
use App\Traits\ApiResponser;

class UbigeoController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UbigeoAdminRequest $request)
    {
        //
        $cod = @$request->input('cod');
        $data = MgUbiGeo::cacheUbigeo(($cod) ? $cod : 0);
        return $this->successResponse((count(@$data) > 0) ? true : false, $data);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MgUbiGeo  $mgUbiGeo
     * @return \Illuminate\Http\Response
     */
    public function show(MgUbiGeo $mgUbiGeo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MgUbiGeo  $mgUbiGeo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MgUbiGeo $mgUbiGeo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MgUbiGeo  $mgUbiGeo
     * @return \Illuminate\Http\Response
     */
    public function destroy(MgUbiGeo $mgUbiGeo)
    {
        //
    }
}
