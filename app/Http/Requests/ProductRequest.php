<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'title_product' => 'required|max:191',
            'category_id' => 'required|string|max:191',
            'new_price' => 'required|numeric|min:1|max:10000000',
            'old_price' => 'required|numeric|min:1|max:10000000',
            'amount_product' => 'required|numeric|min:1|max:10000',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'title_product.required' => 'Tên sản phẩm không được bỏ trống',
            'title_product.max' => 'Tên sản phẩm không được quá 191 kí tự',
        ];
    }
}
