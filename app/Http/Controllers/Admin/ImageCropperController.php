<?php

namespace App\Http\Controllers\Admin;

use App\Galery;
use App\Traits\ApiResponser;
use App\Services\FileImageService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageCropperController extends Controller
{

    use ApiResponser;

    protected $_fileImageService;

    public function __construct(FileImageService $fileImageService)
    {
        $this->_fileImageService = $fileImageService;
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function show(Galery $galery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Galery $galery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galery $galery)
    {
        //
    }

    public function cut(Request $request) {

        $site = (int) $request->route('site');
        $image = (int) $request->route('image');

        $gallery = Galery::where('pc_sites_id', $site)->findOrFail($image);
        $name = $gallery->name;
        $this->_fileImageService->imagecreatelogo($request->input('base64'), $name, $request->orientation);

        return $this->successResponse(true, [], 'imagen cortada');

    }
}
