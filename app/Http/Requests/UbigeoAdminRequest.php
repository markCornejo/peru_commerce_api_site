<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UbigeoAdminRequest extends FormRequest
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
                return [];
                break;
            case 'GET':
            case 'HEAD':
                return [
                    'cod' => 'max:3',
                ];
                break;
            case 'DELETE':
                return [];
                break;
            case 'PATCH':
            case 'PUT':
                return [];
                break;
            default:
                return [];
                break;
       }
    }
}
