<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesPackageMaster extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $array = [
            "id" => $this->id,
            "title" => $this->title,
            "information" => $this->information,
            "price" => $this->price,
            "discount" => $this->discount,
            "image" => $this->image,
            "status" => $this->status,
            "show" => $this->show,
            "sales_packages_lg" => [],
            // "privileges_actions_packages" => []
        ];

        foreach($this->sales_packages_lg as $key => $value) {
            $language = [
                "pc_sales_packages_id" => $value->pc_sales_packages_id,
                "title" => $value->title,
                "information" => $value->information,
                "language" => $value->language,
            ];

            array_push($array["sales_packages_lg"], $language);
        }

        return $array;

    }
}
