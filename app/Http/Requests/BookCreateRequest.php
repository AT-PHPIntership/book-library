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
            'donator_id' => 'required|exists:users,employee_code',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'description' => 'required|string',
            'image'=> 'image|max:10240',
        ];
    }
}
