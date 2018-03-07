<?php
namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Model\Post;

class CreatePostRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            'type' => 'required|in:'.Post::STATUS_TYPE.','
                .Post::FIND_TYPE.','
                .Post::REVIEW_TYPE,
            'content' => 'required|min:10',
        ];
        if ($request->type == Post::REVIEW_TYPE) {
            $rules = array_merge($rules, [
                'rating'  => 'numeric|min:0.5|max:5',
                'book_id' => 'required|exists:books,id',
            ]);
        }
        return $rules;
    }
}
