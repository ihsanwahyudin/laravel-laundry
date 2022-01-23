<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50'],
            'email' => $this->header('status') !== 'update' ? ['required', 'email:dns', 'unique:tb_user,email,except,id'] : ['nullable'],
            'role' => ['required', 'in:admin,kasir'],
            'outlet_id' => ['required', 'numeric'],
            'password' => $this->header('status') !== 'update' ? ['required', 'confirmed', 'min:3'] : ['nullable']
        ];
    }
}
