<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceRequest extends FormRequest
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
            'month' => 'required',
            'opening_balance' => 'required|numeric|min:0|not_in:0',
        ];
    }

    /**
    * Get the message after validation false
    *
    * @return array
    */
    public function messages(){
        return [
            'month.required' => 'Chưa chọn tháng',
            'opening_balance.required' => 'Chưa nhập số dư đầu kì',
            'opening_balance.not_in' => 'Số dư phải lớn hơn 0',
        ];
    }
}
