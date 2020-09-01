<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteAdmin extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "logo" => $this->logo,
            "subdomain" => $this->subdomain,
            "domain" => $this->domain,
            "sales_packages_id" => $this->pc_sales_packages_id,
            "sites_lg" => [],
            "sites_locations" => [],
            "sites_categories" => [],
            "sites_subcategories"  => []
        ];

        foreach($this->sites_lg as $key => $value) {
            $sites_lg = [
                "name" => $value->name,
                "description" => $value->description,
                "language" => $value->language,
            ];

            array_push($array["sites_lg"], $sites_lg);
        }

        foreach($this->sites_locations as $key => $value) {
            $sites_locations = [
                "id" => $value->id,
                "main" => $value->main,
                "lat" => $value->lat,
                "lng" => $value->lng,
                "address" => $value->address,
                "phone" => $value->phone,
            ];

            array_push($array["sites_locations"], $sites_locations);
        }

        foreach($this->sites_categories as $key => $value) {
            $sites_categories = [
                "id" => $value->id,
                "name" => $value->name,
                "schema" => $value->schema,
                "status" => $value->status,
            ];

            array_push($array["sites_categories"], $sites_categories);
        }

        foreach($this->sites_subcategories as $key => $value) {
            $sites_subcategories = [
                "id" => $value->id,
                "name" => $value->name,
                "status" => $value->status,
            ];

            array_push($array["sites_subcategories"], $sites_subcategories);
        }

        return $array;
    }
}
