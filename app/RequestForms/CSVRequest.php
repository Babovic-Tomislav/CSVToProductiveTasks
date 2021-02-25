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
            'csvFile'    => 'required|mimes:csv,text',
            'taskListId' => 'required',
            'projectId'  => 'required'
        ];
    }
}