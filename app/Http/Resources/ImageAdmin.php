<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageAdmin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "site_id" => $this->pc_sites_id,
            "name" => $this->name,
            "dataURL" => $this->dataURL,
            "dataURLx700" => $this->dataURLx700,
            "dataURLx300" => $this->dataURLx300,
            "thumbnailUrl" => $this->thumbnailUrl,
            "typeimage" => $this->typeimage,
            "size" => 23124
        ];
    }
}
