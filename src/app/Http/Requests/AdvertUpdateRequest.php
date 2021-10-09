<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AdvertUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('update', $this->route('advert'))->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:8'],
            'category' => ['required', 'exists:categories,id'],
            'content' => ['required', 'min:20'],
            'pictures.*' => ['image', 'mimes:jpeg,bmp,png', 'max:5000'],
        ];
    }
}
