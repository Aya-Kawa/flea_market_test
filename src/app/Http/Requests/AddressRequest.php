<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
    public function rules()
    {
        return [
            'postal_code' => ['required', 'size:8', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
            'address' => ['required'],
            'building' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.size' => '郵便番号はハイフンを含めて8文字で入力してください。',
            'postal_code.regex' => '郵便番号はハイフンありの形式（123-4567）で入力してください。',
            'address.required' => '住所は必須です。',
        ];
    }
}
