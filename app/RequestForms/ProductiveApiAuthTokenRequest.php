<?php


namespace App\RequestForms;


use Illuminate\Foundation\Http\FormRequest;

class ProductiveApiAuthTokenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'authToken' => 'required'
        ];
    }
}