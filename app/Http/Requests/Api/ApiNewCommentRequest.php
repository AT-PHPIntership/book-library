<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ApiNewCommentRequest extends FormRequest
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
     * @param Request $request request
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'content' => 'required',
            'parent_id' => 'numeric|exists:comments,id'
        ];
    }
}
