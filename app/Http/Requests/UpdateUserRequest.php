<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the users is authorized to make this request.
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
        $userId = request()->route('id');

        return [
            'name' => 'required',
            'phone_number' => 'required',
//            'email' => 'required|email:rfc,dns|unique:users,email,'.$userId,
        ];
    }
}
