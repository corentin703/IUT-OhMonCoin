<?php

namespace App\Http\Requests;

use App\Advert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PictureCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('create', Advert::findOrFail($this->input('advert')))->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pictures.*' => ['image', 'mimes:jpeg,bmp,png', 'max:5000'],
        ];
    }
}
