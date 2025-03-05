<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:250',
            'username'     => 'required|string|max:15|unique:users,username,' . $this->user->id,
            'kd_wilayah'   => 'required|string|max:3',
            'kd_lokasi'    => 'nullable|string|max:5',
            'printer_term' => 'nullable',
            'email'        => 'required|string|email:rfc,dns|max:250|unique:users,email,' . $this->user->id,
            'password'     => 'nullable|string|min:8|confirmed',
            'roles'        => 'required',
        ];
    }
}
