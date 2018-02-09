<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportBookRequest extends FormRequest
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
        return [
            'import-data' => 'required|mimes:csv,txt',
        ];
    }

    public function messages()
    {
        return [
            'import-data.mimes' => __('book.import.validate_file_type'),
        ];
    }
}
