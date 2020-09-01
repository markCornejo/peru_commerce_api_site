<?php

namespace App\Http\Controllers\Admin;

use App\Galery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Imagee;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Traits\ApiResponser;
use App\Services\FileImageService;
use App\Http\Resources\ImageAdmin as ImageAdminResources;
use App\Http\Resources\ImageAdminCollection;
use App\Site;

/**
 * fala crear json response
 */
class ImageController extends Controller
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
    public function index(Request $request)
    {
        //
        $site = $request->route('site');
        // $query = DB::raw("(CASE WHEN user_group='1' THEN 'Admin' WHEN user_group='2' THEN 'User' ELSE 'Superadmin' END) as name");
        $galery = Site::findOrFail($site)->galery->map(function ($ga) {
            $gif = substr($ga->name, -4);
            // var_dump($gif);
            if(@$gif !== ".gif") {
                $ga->dataURL = config('services.image.image_url').'images/450/'.$ga->name;
                $ga->thumbnailUrl = config('services.image.image_url').'images/160/'.$ga->name;
            } else {
                $ga->dataURL = config('services.image.image_url').'images/'.$ga->name;
                $ga->thumbnailUrl = config('services.image.image_url').'images/'.$ga->name;
            }
            return $ga;
        });

        return $this->successResponse(true, new ImageAdminCollection($galery));
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
        $image = $request->url;
        $data = $request->all();
        $data['pc_sites_id'] = $request->route('site');
        $data['type'] = 'image';
        DB::transaction(function () use ($request, $data, $image) {
            if($this->_fileImageService->imagecreatelogo($image, $request->name, $request->orientation)) {
                Galery::create($data);
            }
        });
        // $data = (string) Imagee::make('ipng.png')->encode('data-url');
        // return $image->response('png');
        return $this->successResponse(true, [], 'imagen guardada', Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $site = (int) $request->route('site');
        $image = (int) $request->route('image');

        $gallery = Galery::where('pc_sites_id', $site)->findOrFail($image);
        $name = $gallery->name;
        if(@$gallery->id && $this->_fileImageService->imagedeletelogo($name)) {
            Galery::destroy($image);
        }

        return $this->successResponse(true, $name, 'imagen eliminada');
    }
}
