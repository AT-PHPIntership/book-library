<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookCreateRequest extends FormRequest
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
            'name' => 'required|min:8',
            'author' => 'required',
            'price' => 'required|numeric',
            'donate_by' => 'required',
            'year' => 'required|numeric',
            'image'=> 'image|max:10240',
        ];
    }
}
