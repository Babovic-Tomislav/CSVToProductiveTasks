<?php


namespace App\RequestForms;


use Illuminate\Foundation\Http\FormRequest;

class CSVRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'csv' => 'required|file|mimes:csv',
            'taskList' => 'required'
        ];
    }
}