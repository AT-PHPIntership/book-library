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
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'donate_by' => 'required|exists:user,employee_code',
            'year' => 'required|numeric',
            'description' => 'required|string',
            'image'=> 'image|max:10240',
        ];
    }
}
