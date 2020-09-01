<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // you can also customize your validation for different methods as below
        switch ($this->method()){
            case 'POST':
                return [
                    // 'language_main' => 'required|json',
                    'name' => 'required|string|max:60',
                    'description' => 'required|string|max:1000',
                    'logo' => 'string|max:100',
                    'subdomain' => 'required_without:domain|max:45',
                    'domain' => 'required_without:subdomain|max:45',
                    'users_id' => 'required|int',
                    'locations' => 'array|max:20',
                        'locations.*.pc_countries_id' => 'required|int',
                        'locations.*.main' => 'required|int',
                        'locations.*.lat' => 'string|max:20',
                        'locations.*.lng' => 'string|max:20',
                        'locations.*.address' => 'string|max:100',
                        'locations.*.phone' => 'string|max:15',
                    'language_secondary' => 'array|max:10',
                        'language_secondary.*.name' => 'string|max:60',
                        'language_secondary.*.description' => 'string|max:1000',
                        'language_secondary.*.language' => 'string|max:3'
                ];
                break;
            case 'GET':
            case 'HEAD':
                return [];
                break;
            case 'DELETE':
                return [];
                break;
            case 'PATCH':
            case 'PUT':
                return [
                    // 'language_main' => 'required|json',
                    'name' => 'required|string|max:60',
                    'description' => 'required|string|max:1000',
                    'logo' => 'string|max:100',
                    'subdomain' => 'required_without:domain|max:45',
                    'domain' => 'required_without:subdomain|max:45',
                    'users_id' => 'required|int',
                    'locations' => 'array|max:20',
                        'locations.*.pc_countries_id' => 'int',
                        'locations.*.main' => 'int',
                        'locations.*.lat' => 'string|max:20',
                        'locations.*.lng' => 'string|max:20',
                        'locations.*.address' => 'string|max:100',
                        'locations.*.phone' => 'string|max:15',
                    'language_secondary' => 'array|max:10',
                        'language_secondary.*.name' => 'string|max:60',
                        'language_secondary.*.description' => 'string|max:1000',
                        'language_secondary.*.language' => 'string|max:3'
                ];
                break;
            default:
                return [];
                break;
       }
    }
}
