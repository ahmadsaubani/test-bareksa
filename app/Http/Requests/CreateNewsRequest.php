<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $title
 */
class CreateNewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'                   => 'required',
            'description'             => 'required|min:5',
            'tag_id'                  => 'sometimes|required',
            'topic_id'                => 'sometimes|required',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "title.required"        => "title harus di isi.",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
