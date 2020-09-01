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
            "thumbnailUrl" => $this->thumbnailUrl,
            "size" => 23124
        ];
    }
}
