<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Model\Post;

class UpdatePostRequest extends FormRequest
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
        $postType = request()->route('post')->type;
        switch ($postType) {
            case Post::REVIEW_TYPE:
                $rules = [
                    'content' => 'max:100'
                ];
                break;
            case Post::STATUS_TYPE:
                $rules = [
                    'content' => 'required|max:150',
                ];
                break;
            case Post::FIND_TYPE:
                $rules = [
                    'content' => 'required|max:150'
                ];
                if (isset(request()->image)) {
                    $rules['image'] = 'image';
                }
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }

    /**
     * Set validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type.required' => config('define.post_validate.type_required'),
            'book_id.required' => config('define.post_validate.book_id_required'),
            'rating_id.required' => config('define.post_validate.rating_id_required'),
            'content.required' => config('define.post_validate.content_required'),
            'image.image' => config('define.post_validate.image_image')
        ];
    }
}
