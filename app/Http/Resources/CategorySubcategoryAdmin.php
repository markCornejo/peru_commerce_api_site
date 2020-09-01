<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategorySubcategoryAdmin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        $array = [
            "id" => $this->id,
            "sites_categories" => [],
            "sites_subcategories" => []
        ];

        foreach($this->sites_categories as $key => $value) {
            $cate = [
                "id" => $value->id,
                "name" => $value->name,
                "status" => $value->status,
                "schema" => $value->schema,
            ];

            array_push($array["sites_categories"], $cate);
        }

        foreach($this->sites_subcategories as $key => $value) {
            $subcate = [
                "id" => $value->id,
                "name" => $value->name,
                "status" => $value->status,
            ];

            array_push($array["sites_subcategories"], $subcate);
        }

        return $array;
    }
}
