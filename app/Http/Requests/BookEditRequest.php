<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookEditRequest extends FormRequest
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
            'name'          => 'required',
            'author'        => 'required',
            'price'         => 'required|numeric',
            'employee_code' => 'required',
            'year'          => 'required|digits:4|integer|min:1900|max:'.Carbon::now()->year,
            'description'   => 'required|string',
            'image'         => 'image|max:10240',
            'pages'         => 'required|integer',
        ];
    }
}
