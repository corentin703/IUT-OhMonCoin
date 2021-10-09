<?php

namespace App\Http\Requests;

use App\Category;
use App\Rules\StringEqualRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CategoryDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('update', Category::class)->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd($this->route('category')->name);
        return [
            'name' => ['required', new StringEqualRule($this->route('category')->name)],
        ];
    }
}
