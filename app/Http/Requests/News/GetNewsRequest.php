<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class GetNewsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'columns' => 'sometimes',
            'page' => 'sometimes|integer',
            'order' => 'sometimes|in:asc,desc'
        ];
    }
}
