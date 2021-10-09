<?php

namespace App\Http\Requests;

use App\Message;
use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class MessageCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('create', Message::class)->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'receiver' => ['required', 'exists:users,id'],
            'sender' => ['required', 'exists:users,id'],
            'content' => ['required', 'min:8'],
        ];
    }
}
