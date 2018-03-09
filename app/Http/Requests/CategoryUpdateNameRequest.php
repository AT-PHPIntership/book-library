<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateNameRequest extends FormRequest
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
     * Get the validation rules that apply to the request edit name category.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:categories|max:255',
        ];
    }
}
